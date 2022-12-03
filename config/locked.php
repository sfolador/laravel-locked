<?php

// config for Sfolador/Locked
return [

    'locking_column' => 'locked_at',

    'default_namespace' => 'App\Models',

    'unlock_allowed' => true,
    'can_be_unlocked' => [
    ],

    'prevent_modifications_on_locked_objects' => false,
    'prevent_notifications_to_locked_objects' => false,
];
