<?php

/**
 * Pola wyboru usług w blokach (relationship) — tylko usługi główne.
 * Podstrony (miasta) nie są osobnymi usługami do pokazania w ofercie.
 */

namespace App;

foreach (['offer_services', 'services_items'] as $field) {
    add_filter("acf/fields/relationship/query/name={$field}", function (array $args) {
        $args['post_parent'] = 0;
        $args['orderby'] = 'menu_order';
        $args['order'] = 'ASC';

        return $args;
    });
}
