<?php

// routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Consultation
Breadcrumbs::for('consultation', function (BreadcrumbTrail $trail) {
    $trail->push('Consultation', route('consultation'));
});
Breadcrumbs::for('consultation.details', function (BreadcrumbTrail $trail, string $id) {
    $trail->parent('consultation');
    $trail->push('Consultation Details', route('consultation.details', ['id' => $id]));
});


// Patient
Breadcrumbs::for('patient', function (BreadcrumbTrail $trail) {
    $trail->push('Patient', route('patient'));
});
Breadcrumbs::for('patient.details', function (BreadcrumbTrail $trail, string $id) {
    $trail->parent('patient');
    $trail->push('Patient Details', route('patient.details', ['id' => $id]));
});
