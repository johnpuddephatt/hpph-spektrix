/**
 * Live seat availability for the availability badge.
 *
 * The pages these badges appear on are full-page cached for an hour, so the seat
 * numbers can't be rendered server-side — they'd be frozen at render time. Each
 * badge asks for its own instance and the requests are batched, so a programme
 * listing with 300 badges makes one request, not 300.
 */

const cache = new Map();

let queue = new Map(); // id -> [resolve, ...]
let timer = null;

const UNKNOWN = { seats: -1, accessible_seats: -1 };

/**
 * Ids per request. A full programme listing is ~350 instances and each id is 33
 * characters, so asking for them all at once builds a ~12KB URL — past nginx's
 * default 8KB header buffer, which rejects the request outright. 50 keeps each
 * URL under 2KB with room to spare.
 */
const CHUNK_SIZE = 50;

function flush() {
    timer = null;

    const batch = queue;
    queue = new Map();

    const ids = [...batch.keys()];
    if (!ids.length) return;

    const settle = (chunkIds, data) => {
        chunkIds.forEach((id) => {
            const value = data && data[id] ? data[id] : null;
            if (value) cache.set(id, value);
            (batch.get(id) || []).forEach((resolve) => resolve(value));
        });
    };

    for (let i = 0; i < ids.length; i += CHUNK_SIZE) {
        const chunk = ids.slice(i, i + CHUNK_SIZE);

        fetch(
            `/api/instances/availability?ids=${encodeURIComponent(chunk.join(","))}`,
            { headers: { Accept: "application/json" } }
        )
            .then((response) => (response.ok ? response.json() : null))
            .then((data) => settle(chunk, data))
            // A failure just leaves those badges hidden, which is how they render
            // before data arrives anyway.
            .catch(() => settle(chunk, null));
    }
}

function availabilityFor(id) {
    if (cache.has(id)) {
        return Promise.resolve(cache.get(id));
    }

    return new Promise((resolve) => {
        if (!queue.has(id)) queue.set(id, []);
        queue.get(id).push(resolve);

        // Short delay so all badges rendered in the same tick share one request.
        if (!timer) timer = setTimeout(flush, 20);
    });
}

export default (id) => ({
    // Shaped like the server-rendered value the badge used to receive. With no
    // capacity, seats/capacity is NaN, so the badge stays hidden until data lands.
    instance: { availability: UNKNOWN },

    init() {
        availabilityFor(id).then((availability) => {
            if (availability) {
                this.instance = { availability };
            }
        });
    },
});
