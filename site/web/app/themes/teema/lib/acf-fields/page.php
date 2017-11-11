<?php
/**
 * ACF fields for front page
 */

namespace Geniem\ACF;

// Setting field group
$field_group = new Group( 'Asetukset' );

// Rules
$rule_group_first = new RuleGroup();
$rule_group_first->add_rule( 'page_template', '==', 'models/page-frontpage.php' );

$field_group->add_rule_group( $rule_group_first )
            ->hide_element( 'the_content' );

// Register field group
$field_group->register();
