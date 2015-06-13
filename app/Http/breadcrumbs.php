<?php

// Home
Breadcrumbs::register(
    'home',
    function ($breadcrumbs) {
        $breadcrumbs->push('Home', route('home'));
    }
);

// Home > About
Breadcrumbs::register(
    'about',
    function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('About', route('about'));
    }
);

// home > policy
Breadcrumbs::register(
    'terms',
    function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('Terms of Use', route('terms'));
    }
);

// Home > Contact
Breadcrumbs::register(
    'contact',
    function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('Contact', route('contact'));
    }
);

// home > account
Breadcrumbs::register(
    'myaccount',
    function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('Account', route(auth()->check() ? 'myaccount' : 'login'));
    }
);

// home > help > faq
Breadcrumbs::register(
    'faq',
    function ($breadcrumbs) {
        $breadcrumbs->parent('help');
        $breadcrumbs->push('FAQ', route('faq'));
    }
);

// home > help
Breadcrumbs::register(
    'help',
    function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('help', route('help'));
    }
);

// home > help > [article topic]
Breadcrumbs::register(
    'help.article.view',
    function ($breadcrumbs, $article) {
        $breadcrumbs->parent('help');
        $breadcrumbs->push($article->topic, $article->topic);
    }
);

// Home > orders
Breadcrumbs::register(
    'myorders',
    function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('My Orders', route('myorders'));
    }
);

// Home > orders > [order id]
Breadcrumbs::register(
    'viewOrder',
    function ($breadcrumbs, $order) {
        $breadcrumbs->parent('myorders');
        $breadcrumbs->push("Order # {$order->id}", "Order # {$order->id}");
    }
);

// home > account > login
Breadcrumbs::register(
    'login',
    function ($breadcrumbs) {
        $breadcrumbs->parent('myaccount');
        $breadcrumbs->push('login', route('login'));
    }
);
// home > account > login #outh registration page
Breadcrumbs::register(
    'auth.fill',
    function ($breadcrumbs) {
        $breadcrumbs->parent('myaccount');
        $breadcrumbs->push('login', route('login'));
    }
);

// home > account > register
Breadcrumbs::register(
    'register',
    function ($breadcrumbs) {
        $breadcrumbs->parent('myaccount');
        $breadcrumbs->push('Register', route('register'));
    }
);

// home > cart
Breadcrumbs::register(
    'cart.view',
    function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('Shopping cart', route('cart.view'));
    }
);

// home > cart > checkout
Breadcrumbs::register(
    'checkout.auth',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cart.view');
        $breadcrumbs->push('Checkout', route('checkout.auth'));
    }
);

// home > [category Name]
Breadcrumbs::register('categories.shop', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($category->name, route('categories.shop', ['category' => $category->id]));
});

// home > [category Name] > [subcategory Name]
Breadcrumbs::register('subcategories.shop', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('home');

    $data = $category->category()->get(['name', 'id']);
    foreach ($data as $cat) {
        $breadcrumbs->push($cat->name, route('categories.shop', ['category' => $cat->id]));
    }

    $breadcrumbs->push($category->name, route('subcategories.shop', ['subcategory' => $category->id]));
});

// home > brands
Breadcrumbs::register(
    'allBrands',
    function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('brands', route('allBrands'));
    }
);

// home > brands > [brand Name]
Breadcrumbs::register('brands.shop', function ($breadcrumbs, $brand) {
    $breadcrumbs->parent('allBrands');
    $breadcrumbs->push($brand->name, route('brands.shop', ['brand' => $brand->id]));
});

// home > products
Breadcrumbs::register(
    'allProducts',
    function ($breadcrumbs) {
        $breadcrumbs->parent('home');
        $breadcrumbs->push('products', route('allProducts'));
    }
);

// home > [category Name] > [subcategory name] > [product Name]
Breadcrumbs::register('product.view', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('home');

    $category = $product->category()->get(['name', 'id']);
    $subcategory = $product->subcategory()->get(['name', 'id']);
    $brand = $product->brand()->get(['name', 'id']);
    foreach ($category as $cat) {
        $breadcrumbs->push($cat->name, route('categories.shop', ['category' => $cat->id]));
        foreach ($subcategory as $sub) {
            $breadcrumbs->push($sub->name, route('subcategories.shop', ['subcategory' => $sub->id]));
        }
        foreach ($brand as $br) {
            $breadcrumbs->push($br->name, route('brands.shop', ['brand' => $br->id]));
        }

    }

    $breadcrumbs->push("product # " . $product->sku, route('product.view', ['product' => $product->id]));
});

require __DIR__ . '/backend_breadcrumbs.php';