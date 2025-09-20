<?php

use App\Models\AccessTag;

AccessTag::all()->filter(fn($tag) => !$instance->{$tag->slug} ?? false);



// // Javascript
// const instances = [
//   { access_tags: ['captioned', 'audio_described'] },
//   { access_tags: ['toddler_friendly', 'audio_described'] }
// ];

// const allTags = Array.from(
//   new Set(instances.flatMap(instance => instance.access_tags))
// );

// console.log(allTags); // ['captioned', 'audio_described', 'toddler_friendly']