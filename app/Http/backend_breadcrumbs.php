<?php

// Home
Breadcrumbs::register(
    'backend',
    function ($breadcrumbs) {
        $breadcrumbs->push('Home', route('backend'));
    }
);

Breadcrumbs::register(
    'backend.articles.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend');
        $breadcrumbs->push('Articles', route('backend.articles.index'));
    }
);


Breadcrumbs::register(
    'backend.articles.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend.articles.index');
        $breadcrumbs->push('Create', 'Create');
    }
);

Breadcrumbs::register(
    'backend.counties.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend');
        $breadcrumbs->push('Counties', route('backend.counties.index'));
    }
);

Breadcrumbs::register(
    'backend.counties.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend.counties.index');
        $breadcrumbs->push('Create', 'Create');
    }
);

Breadcrumbs::register(
    'backend.users.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend');
        $breadcrumbs->push('Users', route('backend.users.index'));
    }
);

Breadcrumbs::register(
    'backend.users.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend.users.index');
        $breadcrumbs->push('Create', 'Create');
    }
);

Breadcrumbs::register(
    'backend.categories.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend');
        $breadcrumbs->push('Categories', route('backend.categories.index'));
    }
);

Breadcrumbs::register(
    'backend.categories.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend.categories.index');
        $breadcrumbs->push('Create', 'Create');
    }
);

Breadcrumbs::register(
    'backend.subcategories.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend');
        $breadcrumbs->push('Subcategories', route('backend.subcategories.index'));
    }
);

Breadcrumbs::register(
    'backend.subcategories.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend.subcategories.index');
        $breadcrumbs->push('Create', 'Create');
    }
);

Breadcrumbs::register(
    'backend.brands.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend');
        $breadcrumbs->push('Brands', route('backend.brands.index'));
    }
);

Breadcrumbs::register(
    'backend.brands.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend.brands.index');
        $breadcrumbs->push('Create', 'Create');
    }
);

Breadcrumbs::register(
    'backend.products.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend');
        $breadcrumbs->push('Products', route('backend.products.index'));
    }
);

Breadcrumbs::register(
    'backend.products.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('backend.products.index');
        $breadcrumbs->push('Create', 'Create');
    }
);