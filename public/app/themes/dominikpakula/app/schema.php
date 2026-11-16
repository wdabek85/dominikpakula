<?php

/**
 * Dane strukturalne: modyfikacja grafu JSON-LD Rank Math (jeden <script>, bez dublowania).
 * Logika w app/Schema/.
 */

namespace App;

use App\Schema\Graph;

add_filter('rank_math/schema/add_global_entities', [Graph::class, 'addGlobalEntities']);
add_filter('rank_math/json_ld', [Graph::class, 'filter'], 99);
