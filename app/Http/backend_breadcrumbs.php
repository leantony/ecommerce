<?php

// Home
Breadcrumbs::register(
    'backend',
    function ($breadcrumbs) {
        $breadcrumbs->push('Home', route('backend'));
    }
);

// articles
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

Breadcrumbs::register('backend.articles.edit', function ($breadcrumbs, $article) {
    $breadcrumbs->parent('backend.articles.index');
    $breadcrumbs->push($article->topic, route('backend.articles.edit', ['article' => $article->id]));
});

// counties
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

Breadcrumbs::register('backend.counties.edit', function ($breadcrumbs, $county) {
    $breadcrumbs->parent('backend.counties.index');
    $breadcrumbs->push($county->name, route('backend.counties.edit', ['counties' => $county->id]));
});

// users
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

Breadcrumbs::register('backend.users.edit', function ($breadcrumbs, $users) {
    $breadcrumbs->parent('backend.users.index');
    $breadcrumbs->push($users->present()->fullName, route('backend.users.edit', ['users' => $users->id]));
});

// categories
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

Breadcrumbs::register('backend.categories.edit', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('backend.categories.index');
    $breadcrumbs->push($category->name, route('backend.categories.edit', ['categories' => $category->id]));
});

// subcategories
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

Breadcrumbs::register('backend.subcategories.edit', function ($breadcrumbs, $subcategory) {
    $breadcrumbs->parent('backend.subcategories.index');
    $breadcrumbs->push($subcategory->name, route('backend.subcategories.edit', ['subcategories' => $subcategory->id]));
});

// brands
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

Breadcrumbs::register('backend.brands.edit', function ($breadcrumbs, $brand) {
    $breadcrumbs->parent('backend.brands.index');
    $breadcrumbs->push($brand->name, route('backend.brands.edit', ['brands' => $brand->id]));
});

// products
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

Breadcrumbs::register('backend.products.edit', function ($breadcrumbs, $products) {
    $breadcrumbs->parent('backend.products.index');
    $breadcrumbs->push($products->name, route('backend.products.edit', ['products' => $products->id]));
});