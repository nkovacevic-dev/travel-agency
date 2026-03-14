<?php
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('pocetna', function ($trail) {
    $trail->push(__('Početna'), route('pocetna'));
});
Breadcrumbs::for('putovanja.index', function ($trail) {
    $trail->parent('pocetna');
    $trail->push(__('Putovanja'), route('putovanja.index'));
});
Breadcrumbs::for('putovanja.create', function ($trail) {
    $trail->parent('putovanja.index');
    $trail->push(__('Unos'), route('putovanja.create'));
});
Breadcrumbs::for('putovanja.show', function ($trail, $id) {
    $trail->parent('putovanja.index');
    $trail->push(__('Prikaz'), route('putovanja.show', $id));
});
Breadcrumbs::for('putovanja.edit', function ($trail, $id) {
    $trail->parent('putovanja.show', $id);
    $trail->push(__('Izmena'), route('putovanja.edit', $id));
});
Breadcrumbs::for('hoteli.index', function ($trail) {
    $trail->parent('pocetna');
    $trail->push(__('Hoteli'), route('hoteli.index'));
});
Breadcrumbs::for('hoteli.create', function ($trail) {
    $trail->parent('hoteli.index');
    $trail->push(__('Unos'), route('hoteli.create'));
});
Breadcrumbs::for('hoteli.show', function ($trail, $id) {
    $trail->parent('hoteli.index');
    $trail->push(__('Prikaz'), route('hoteli.show', $id));
});
Breadcrumbs::for('hoteli.edit', function ($trail, $id) {
    $trail->parent('hoteli.show', $id);
    $trail->push(__('Izmena'), route('hoteli.edit', $id));
});

// Rezervacije
Breadcrumbs::for('rezervacije.index', function ($trail) {
    $trail->parent('pocetna');
    $trail->push(__('Rezervacije'), route('rezervacije.index'));
});
Breadcrumbs::for('rezervacije.create', function ($trail) {
    $trail->parent('rezervacije.index');
    $trail->push(__('Unos'), route('rezervacije.create'));
});
Breadcrumbs::for('rezervacije.show', function ($trail, $id) {
    $trail->parent('rezervacije.index');
    $trail->push(__('Prikaz'), route('rezervacije.show', $id));
});
Breadcrumbs::for('rezervacije.edit', function ($trail, $id) {
    $trail->parent('rezervacije.show', $id);
    $trail->push(__('Izmena'), route('rezervacije.edit', $id));
});

Breadcrumbs::for('putnici.index', function ($trail) {
    $trail->parent('pocetna');
    $trail->push(__('Korisnici'), route('putnici.index'));
});
Breadcrumbs::for('putnici.create', function ($trail) {
    $trail->parent('putnici.index');
    $trail->push(__('Unos korisnika'), route('putnici.create'));
});

Breadcrumbs::for('putnici.edit', function ($trail,$id) {
    $trail->parent('putnici.index');
    $trail->push(__('Izmena korisnika'), route('putnici.edit', $id));
});
Breadcrumbs::for('putnici.show', function ($trail, $id) {
    $trail->parent('putnici.index');
    $trail->push(__('Prikaz korisnika'), route('putnici.show', $id));
});

Breadcrumbs::for('ponuda.create', function ($trail) {
    $trail->parent('ponuda');
    $trail->push(__('Unos ponude'), route('ponuda.create'));
});

Breadcrumbs::for('ponuda.edit', function ($trail,$id) {
    $trail->parent('ponuda');
    $trail->push(__('Izmena ponude'), route('ponuda.edit', $id));
});

Breadcrumbs::for('ponuda.show', function ($trail, $id) {
    $trail->parent('ponuda');
    $trail->push(__('Prikaz ponude'), route('ponuda.show', $id));
});

