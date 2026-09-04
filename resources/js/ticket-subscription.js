/**
 * Adds a ticket subscription (flex pass) to the Spektrix basket.
 *
 * Spektrix ships no web component for ticket subscriptions — unlike memberships,
 * donations and merchandise — so this posts to the v3 API directly. Three things
 * about that call are load-bearing:
 *
 * 1. It must run in the browser. The singular /basket/ endpoints act on the
 *    session's basket, and that session is the Spektrix cookie the iframes carry.
 *    A signed server-side call from Laravel would land in an unrelated basket.
 *
 * 2. credentials: "include" is required. It's a cross-origin request (the site is
 *    hpph.co.uk, Spektrix is tickets.hpph.co.uk) and cookies are not sent on CORS
 *    requests by default. Without it, every add starts a fresh empty basket.
 *
 * 3. Content-Type is the only header allowed. The preflight response lists
 *    access-control-allow-headers: content-type, so adding Accept — the obvious
 *    thing to reach for — fails preflight before the request is ever made.
 *
 * Nothing needs to tell the basket summary about the new item: it polls its own
 * count once a second.
 */

const IDLE = "idle";
const BUSY = "busy";
const DONE = "done";
const FAILED = "failed";

/**
 * One instance per buy option, not one per subscription: each pricing set has
 * its own button, and a shared instance would put every button on a
 * subscription into the same busy/added state on the first click.
 */
export default ({ endpoint, pricingSetId }) => ({
    state: IDLE,

    get busy() {
        return this.state === BUSY;
    },

    get added() {
        return this.state === DONE;
    },

    get failed() {
        return this.state === FAILED;
    },

    async add() {
        if (this.busy || !pricingSetId) return;

        this.state = BUSY;

        try {
            const response = await fetch(endpoint, {
                method: "POST",
                credentials: "include",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify([{ pricingSetId, quantity: 1 }]),
            });

            if (!response.ok) throw new Error(response.status);

            this.state = DONE;
        } catch (error) {
            this.state = FAILED;
        }
    },
});
