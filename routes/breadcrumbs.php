<?php

// routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Consultation
Breadcrumbs::for('consultations', function (BreadcrumbTrail $trail, ?string $status = null) {
    if (! empty($status)) {
        if (!in_array($status, ['pending', 'completed'])) {
            abort(404);
        }
        $trail->parent('consultations');
        $trail->push(ucfirst($status), route('consultations', ['status' => $status]));
    } else {
        $trail->push('Consultation', route('consultations'));
    }

});

Breadcrumbs::for('consultation.details', function (BreadcrumbTrail $trail, string $consultationId) {
    $trail->parent('consultations');
    $trail->push('Consultation Details', route('consultation.details', ['consultationId' => $consultationId]));
});

// Patient
Breadcrumbs::for('patients', function (BreadcrumbTrail $trail) {
    $trail->push('Patient List', route('patients'));
});
Breadcrumbs::for('patient.details', function (BreadcrumbTrail $trail, string $id) {
    $trail->parent('patients');
    $trail->push('Patient Details', route('patient.details', ['id' => $id]));
});

// User
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->push('Users', route('users'));
});
Breadcrumbs::for('user.details', function (BreadcrumbTrail $trail, string $id) {
    $trail->parent('users');
    $trail->push('User Details', route('user.details', ['id' => $id]));
});

// Front Desk
Breadcrumbs::for('front-desk', function (BreadcrumbTrail $trail) {
    $trail->push('Front Desk', route('front-desk'));
});

// Laboratory
Breadcrumbs::for('laboratory', function (BreadcrumbTrail $trail, ?string $status = null) {
    if (! empty($status)) {
        if (!in_array($status, ['pending', 'completed'])) {
            abort(404);
        }
        $trail->parent('laboratory');
        $trail->push(ucfirst($status), route('laboratory', ['status' => $status]));
    } else {
        $trail->push('Laboratory', route('laboratory'));
    }

});
Breadcrumbs::for('laboratory.details', function (BreadcrumbTrail $trail, string $id) {
    $trail->parent('laboratory');
    $trail->push('Laboratory Details', route('laboratory.details', ['id' => $id]));
});