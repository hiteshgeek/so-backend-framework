<?php
/**
 * SixOrbit UI Engine - Carousel Element Demo
 */

$pageTitle = 'Carousel - UI Engine';
$pageDescription = 'Slideshow component for cycling through images';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Carousel</h1>
            <p class="so-page-subtitle">Slideshow component for cycling through images or content with navigation controls.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Carousel -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Carousel</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">A simple image carousel with navigation controls and indicators.</p>

                <!-- Live Demo -->
                <div class="so-carousel so-mb-4" data-so-carousel id="basic-demo-carousel">
                    <div class="so-carousel-inner">
                        <div class="so-carousel-slide so-active">
                            <img src="https://picsum.photos/800/400?random=101" alt="Slide 1">
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/400?random=102" alt="Slide 2">
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/400?random=103" alt="Slide 3">
                        </div>
                    </div>

                    <button class="so-carousel-control so-carousel-control-prev" aria-label="Previous slide">
                        <span class="material-icons">chevron_left</span>
                    </button>
                    <button class="so-carousel-control so-carousel-control-next" aria-label="Next slide">
                        <span class="material-icons">chevron_right</span>
                    </button>

                    <div class="so-carousel-indicators">
                        <button class="so-carousel-indicator so-active" data-so-slide="0" aria-label="Go to slide 1"></button>
                        <button class="so-carousel-indicator" data-so-slide="1" aria-label="Go to slide 2"></button>
                        <button class="so-carousel-indicator" data-so-slide="2" aria-label="Go to slide 3"></button>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-carousel', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$carousel = UiEngine::carousel('demo-carousel')
    ->slide('/images/slide1.jpg', 'First slide')
    ->slide('/images/slide2.jpg', 'Second slide')
    ->slide('/images/slide3.jpg', 'Third slide')
    ->controls()
    ->indicators();

echo \$carousel->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const carousel = UiEngine.carousel('demo-carousel')
    .slide('/images/slide1.jpg', 'First slide')
    .slide('/images/slide2.jpg', 'Second slide')
    .slide('/images/slide3.jpg', 'Third slide')
    .controls()
    .indicators();

document.getElementById('container').innerHTML = carousel.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-carousel" data-so-carousel>
    <div class="so-carousel-inner">
        <div class="so-carousel-slide so-active">
            <img src="slide1.jpg" alt="Slide 1">
        </div>
        <div class="so-carousel-slide">
            <img src="slide2.jpg" alt="Slide 2">
        </div>
        <div class="so-carousel-slide">
            <img src="slide3.jpg" alt="Slide 3">
        </div>
    </div>

    <button class="so-carousel-control so-carousel-control-prev">
        <span class="material-icons">chevron_left</span>
    </button>
    <button class="so-carousel-control so-carousel-control-next">
        <span class="material-icons">chevron_right</span>
    </button>

    <div class="so-carousel-indicators">
        <button class="so-carousel-indicator so-active" data-so-slide="0"></button>
        <button class="so-carousel-indicator" data-so-slide="1"></button>
        <button class="so-carousel-indicator" data-so-slide="2"></button>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Captions -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Captions</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add captions with gradient overlay to provide context for each slide.</p>

                <!-- Live Demo -->
                <div class="so-carousel so-mb-4" data-so-carousel id="caption-demo-carousel">
                    <div class="so-carousel-inner">
                        <div class="so-carousel-slide so-active">
                            <img src="https://picsum.photos/800/450?random=104" alt="Mountains">
                            <div class="so-carousel-caption">
                                <h4 class="so-carousel-caption-title">Mountain Adventure</h4>
                                <p class="so-carousel-caption-text">Explore the beauty of nature's majestic peaks.</p>
                            </div>
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/450?random=105" alt="Ocean">
                            <div class="so-carousel-caption">
                                <h4 class="so-carousel-caption-title">Ocean Dreams</h4>
                                <p class="so-carousel-caption-text">Discover the tranquility of endless horizons.</p>
                            </div>
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/450?random=106" alt="Forest">
                            <div class="so-carousel-caption">
                                <h4 class="so-carousel-caption-title">Forest Escape</h4>
                                <p class="so-carousel-caption-text">Find peace in the heart of ancient woodlands.</p>
                            </div>
                        </div>
                    </div>

                    <button class="so-carousel-control so-carousel-control-prev" aria-label="Previous">
                        <span class="material-icons">chevron_left</span>
                    </button>
                    <button class="so-carousel-control so-carousel-control-next" aria-label="Next">
                        <span class="material-icons">chevron_right</span>
                    </button>

                    <div class="so-carousel-indicators">
                        <button class="so-carousel-indicator so-active" data-so-slide="0"></button>
                        <button class="so-carousel-indicator" data-so-slide="1"></button>
                        <button class="so-carousel-indicator" data-so-slide="2"></button>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('carousel-captions', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$carousel = UiEngine::carousel('caption-carousel')
    ->slide('/images/slide1.jpg', 'First slide', [
        'title' => 'Welcome to Our Platform',
        'description' => 'Discover amazing features',
    ])
    ->slide('/images/slide2.jpg', 'Second slide', [
        'title' => 'Powerful Tools',
        'description' => 'Everything you need in one place',
    ])
    ->slide('/images/slide3.jpg', 'Third slide', [
        'title' => 'Get Started Today',
        'description' => 'Join thousands of satisfied users',
    ])
    ->controls()
    ->indicators();

echo \$carousel->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const carousel = UiEngine.carousel('caption-carousel')
    .slide('/images/slide1.jpg', 'First slide', {
        title: 'Welcome to Our Platform',
        description: 'Discover amazing features',
    })
    .slide('/images/slide2.jpg', 'Second slide', {
        title: 'Powerful Tools',
        description: 'Everything you need in one place',
    })
    .slide('/images/slide3.jpg', 'Third slide', {
        title: 'Get Started Today',
        description: 'Join thousands of satisfied users',
    })
    .controls()
    .indicators();

document.getElementById('container').innerHTML = carousel.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-carousel" data-so-carousel>
    <div class="so-carousel-inner">
        <div class="so-carousel-slide so-active">
            <img src="slide1.jpg" alt="First slide">
            <div class="so-carousel-caption">
                <h4 class="so-carousel-caption-title">Welcome to Our Platform</h4>
                <p class="so-carousel-caption-text">Discover amazing features</p>
            </div>
        </div>
        <!-- More slides... -->
    </div>
    <!-- Controls and indicators... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Crossfade Effect -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Crossfade Effect</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Use <code>.so-carousel-fade</code> for a crossfade effect instead of sliding.</p>

                <!-- Live Demo -->
                <div class="so-carousel so-carousel-fade so-mb-4" data-so-carousel id="fade-demo-carousel">
                    <div class="so-carousel-inner">
                        <div class="so-carousel-slide so-active">
                            <img src="https://picsum.photos/800/400?random=107" alt="Slide 1">
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/400?random=108" alt="Slide 2">
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/400?random=109" alt="Slide 3">
                        </div>
                    </div>

                    <button class="so-carousel-control so-carousel-control-prev" aria-label="Previous">
                        <span class="material-icons">chevron_left</span>
                    </button>
                    <button class="so-carousel-control so-carousel-control-next" aria-label="Next">
                        <span class="material-icons">chevron_right</span>
                    </button>

                    <div class="so-carousel-indicators so-carousel-indicators-line">
                        <button class="so-carousel-indicator so-active" data-so-slide="0"></button>
                        <button class="so-carousel-indicator" data-so-slide="1"></button>
                        <button class="so-carousel-indicator" data-so-slide="2"></button>
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('carousel-fade', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$carousel = UiEngine::carousel('fade-carousel')
    ->slides([...])
    ->fade()  // Use crossfade instead of slide
    ->controls()
    ->indicators('line');  // Line-style indicators

echo \$carousel->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const carousel = UiEngine.carousel('fade-carousel')
    .slides([...])
    .fade()
    .controls()
    .indicators('line');

document.getElementById('container').innerHTML = carousel.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-carousel so-carousel-fade" data-so-carousel>
    <div class="so-carousel-inner">
        <div class="so-carousel-slide so-active">
            <img src="slide1.jpg" alt="Slide 1">
        </div>
        <!-- More slides... -->
    </div>

    <!-- Controls... -->

    <!-- Line-style indicators -->
    <div class="so-carousel-indicators so-carousel-indicators-line">
        <button class="so-carousel-indicator so-active" data-so-slide="0"></button>
        <button class="so-carousel-indicator" data-so-slide="1"></button>
        <button class="so-carousel-indicator" data-so-slide="2"></button>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Autoplay with Progress -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Autoplay with Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Automatically advance slides with a visual progress indicator. Pauses on hover.</p>

                <!-- Live Demo -->
                <div class="so-carousel so-carousel-autoplay so-mb-4" data-so-carousel data-so-autoplay="true" data-so-interval="4000" id="autoplay-demo-carousel">
                    <div class="so-carousel-inner">
                        <div class="so-carousel-slide so-active">
                            <img src="https://picsum.photos/800/400?random=110" alt="Auto 1">
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/400?random=111" alt="Auto 2">
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/400?random=112" alt="Auto 3">
                        </div>
                    </div>

                    <button class="so-carousel-control so-carousel-control-prev" aria-label="Previous">
                        <span class="material-icons">chevron_left</span>
                    </button>
                    <button class="so-carousel-control so-carousel-control-next" aria-label="Next">
                        <span class="material-icons">chevron_right</span>
                    </button>

                    <div class="so-carousel-indicators">
                        <button class="so-carousel-indicator so-active" data-so-slide="0"></button>
                        <button class="so-carousel-indicator" data-so-slide="1"></button>
                        <button class="so-carousel-indicator" data-so-slide="2"></button>
                    </div>

                    <div class="so-carousel-progress">
                        <div class="so-carousel-progress-bar"></div>
                    </div>
                </div>

                <div class="so-d-flex so-gap-2 so-mb-4">
                    <button class="so-btn so-btn-sm so-btn-primary" id="autoplay-play-btn">
                        <span class="material-icons" style="font-size:18px;">play_arrow</span> Play
                    </button>
                    <button class="so-btn so-btn-sm so-btn-outline-secondary" id="autoplay-pause-btn">
                        <span class="material-icons" style="font-size:18px;">pause</span> Pause
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('carousel-autoplay', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$carousel = UiEngine::carousel('autoplay-carousel')
    ->slides([...])
    ->controls()
    ->indicators()
    ->autoplay(4000)  // Auto-advance every 4 seconds
    ->progress()      // Show progress bar
    ->pause('hover'); // Pause on hover

echo \$carousel->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const carousel = UiEngine.carousel('autoplay-carousel')
    .slides([...])
    .controls()
    .indicators()
    .autoplay(4000)
    .progress()
    .pause('hover');

document.getElementById('container').innerHTML = carousel.toHtml();

// Control autoplay programmatically
carousel.play();   // Start autoplay
carousel.pause();  // Pause autoplay
carousel.stop();   // Stop completely"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-carousel so-carousel-autoplay"
     data-so-carousel
     data-so-autoplay="true"
     data-so-interval="4000">
    <div class="so-carousel-inner">
        <!-- slides... -->
    </div>

    <!-- controls... -->
    <!-- indicators... -->

    <div class="so-carousel-progress">
        <div class="so-carousel-progress-bar"></div>
    </div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Multi-Item Carousel -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Multi-Item Carousel</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display multiple items at once using <code>.so-carousel-multi</code>. Perfect for product carousels.</p>

                <!-- Live Demo -->
                <div class="so-carousel so-carousel-multi so-carousel-cards so-mb-4" data-so-carousel data-so-items="3" id="multi-demo-carousel">
                    <div class="so-carousel-inner">
                        <div class="so-carousel-slide so-active">
                            <div class="so-card">
                                <img src="https://picsum.photos/400/250?random=113" alt="Product 1" style="width:100%; border-radius: 8px 8px 0 0;">
                                <div class="so-card-body">
                                    <h5 class="so-card-title">Product One</h5>
                                    <p class="so-text-muted">Starting at $99</p>
                                </div>
                            </div>
                        </div>
                        <div class="so-carousel-slide">
                            <div class="so-card">
                                <img src="https://picsum.photos/400/250?random=114" alt="Product 2" style="width:100%; border-radius: 8px 8px 0 0;">
                                <div class="so-card-body">
                                    <h5 class="so-card-title">Product Two</h5>
                                    <p class="so-text-muted">Starting at $149</p>
                                </div>
                            </div>
                        </div>
                        <div class="so-carousel-slide">
                            <div class="so-card">
                                <img src="https://picsum.photos/400/250?random=115" alt="Product 3" style="width:100%; border-radius: 8px 8px 0 0;">
                                <div class="so-card-body">
                                    <h5 class="so-card-title">Product Three</h5>
                                    <p class="so-text-muted">Starting at $199</p>
                                </div>
                            </div>
                        </div>
                        <div class="so-carousel-slide">
                            <div class="so-card">
                                <img src="https://picsum.photos/400/250?random=116" alt="Product 4" style="width:100%; border-radius: 8px 8px 0 0;">
                                <div class="so-card-body">
                                    <h5 class="so-card-title">Product Four</h5>
                                    <p class="so-text-muted">Starting at $249</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="so-carousel-control so-carousel-control-prev" aria-label="Previous">
                        <span class="material-icons">chevron_left</span>
                    </button>
                    <button class="so-carousel-control so-carousel-control-next" aria-label="Next">
                        <span class="material-icons">chevron_right</span>
                    </button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('carousel-multi', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$carousel = UiEngine::carousel('multi-carousel')
    ->multi(3)  // Show 3 items at once
    ->cards()   // Card-style slides
    ->slideContent(UiEngine::card()->title('Product 1')->body('Description'))
    ->slideContent(UiEngine::card()->title('Product 2')->body('Description'))
    ->slideContent(UiEngine::card()->title('Product 3')->body('Description'))
    ->slideContent(UiEngine::card()->title('Product 4')->body('Description'))
    ->controls();

echo \$carousel->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const carousel = UiEngine.carousel('multi-carousel')
    .multi(3)
    .cards()
    .slideContent(UiEngine.card().title('Product 1').body('Description').toHtml())
    .slideContent(UiEngine.card().title('Product 2').body('Description').toHtml())
    .slideContent(UiEngine.card().title('Product 3').body('Description').toHtml())
    .slideContent(UiEngine.card().title('Product 4').body('Description').toHtml())
    .controls();

document.getElementById('container').innerHTML = carousel.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-carousel so-carousel-multi so-carousel-cards" data-so-carousel data-so-items="3">
    <div class="so-carousel-inner">
        <div class="so-carousel-slide so-active">
            <div class="so-card">
                <div class="so-card-body">
                    <h5 class="so-card-title">Product 1</h5>
                    <p>Description</p>
                </div>
            </div>
        </div>
        <!-- More slides... -->
    </div>
    <!-- Controls... -->
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Programmatic Control -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Programmatic Control</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control carousels via JavaScript API.</p>

                <!-- Live Demo -->
                <div class="so-carousel so-mb-4" data-so-carousel id="api-demo-carousel">
                    <div class="so-carousel-inner">
                        <div class="so-carousel-slide so-active">
                            <img src="https://picsum.photos/800/350?random=117" alt="API 1">
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/350?random=118" alt="API 2">
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/350?random=119" alt="API 3">
                        </div>
                        <div class="so-carousel-slide">
                            <img src="https://picsum.photos/800/350?random=120" alt="API 4">
                        </div>
                    </div>
                    <div class="so-carousel-indicators">
                        <button class="so-carousel-indicator so-active" data-so-slide="0"></button>
                        <button class="so-carousel-indicator" data-so-slide="1"></button>
                        <button class="so-carousel-indicator" data-so-slide="2"></button>
                        <button class="so-carousel-indicator" data-so-slide="3"></button>
                    </div>
                </div>

                <div class="so-d-flex so-flex-wrap so-gap-2 so-mb-4">
                    <button class="so-btn so-btn-sm so-btn-primary" id="api-prev-btn">
                        <span class="material-icons" style="font-size:18px;">chevron_left</span> Prev
                    </button>
                    <button class="so-btn so-btn-sm so-btn-primary" id="api-next-btn">
                        Next <span class="material-icons" style="font-size:18px;">chevron_right</span>
                    </button>
                    <button class="so-btn so-btn-sm so-btn-outline-secondary" id="api-goto-0">Go to 1</button>
                    <button class="so-btn so-btn-sm so-btn-outline-secondary" id="api-goto-1">Go to 2</button>
                    <button class="so-btn so-btn-sm so-btn-outline-secondary" id="api-goto-2">Go to 3</button>
                    <button class="so-btn so-btn-sm so-btn-outline-secondary" id="api-goto-3">Go to 4</button>
                    <button class="so-btn so-btn-sm so-btn-outline-info" id="api-get-index">Get Index</button>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('carousel-control', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// PHP generates the carousel HTML
// JavaScript controls the carousel programmatically

\$carousel = UiEngine::carousel('control-carousel')
    ->slides([...])
    ->indicators()
    ->onSlide('handleSlideChange');

echo \$carousel->render();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const carousel = UiEngine.carousel('control-carousel')
    .slides([...])
    .onSlide((from, to) => {
        console.log('Sliding from', from, 'to', to);
    });

// Control methods
carousel.next();      // Go to next slide
carousel.prev();      // Go to previous slide
carousel.goTo(2);     // Go to specific slide
carousel.pause();     // Pause autoplay
carousel.cycle();     // Resume autoplay

// Get state
carousel.getCurrentIndex();  // Get current slide index
carousel.getSlideCount();    // Get total slides"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- Get carousel instance -->
<script>
const carousel = SOCarousel.getInstance(document.getElementById(\'my-carousel\'));

// Navigate
carousel.next();           // Go to next slide
carousel.prev();           // Go to previous slide
carousel.goTo(2);          // Go to slide at index 2

// Get state
carousel.getCurrentIndex(); // Get current slide index
carousel.getSlideCount();   // Get total number of slides
</script>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Method</th>
                                <th>Parameters</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>slide()</code></td>
                                <td><code>string $image, string $alt, array $options</code></td>
                                <td>Add an image slide</td>
                            </tr>
                            <tr>
                                <td><code>slideContent()</code></td>
                                <td><code>string $html</code></td>
                                <td>Add custom content slide</td>
                            </tr>
                            <tr>
                                <td><code>controls()</code></td>
                                <td>-</td>
                                <td>Show prev/next arrows</td>
                            </tr>
                            <tr>
                                <td><code>indicators()</code></td>
                                <td><code>string $style</code></td>
                                <td>Show indicators (dot or line)</td>
                            </tr>
                            <tr>
                                <td><code>autoplay()</code></td>
                                <td><code>int $interval</code></td>
                                <td>Auto-advance interval in ms</td>
                            </tr>
                            <tr>
                                <td><code>fade()</code></td>
                                <td>-</td>
                                <td>Use crossfade transition</td>
                            </tr>
                            <tr>
                                <td><code>multi()</code></td>
                                <td><code>int $items</code></td>
                                <td>Show multiple items at once</td>
                            </tr>
                            <tr>
                                <td><code>pause()</code></td>
                                <td><code>string $event</code></td>
                                <td>Pause on event (hover, false)</td>
                            </tr>
                            <tr>
                                <td><code>onSlide()</code></td>
                                <td><code>callable $callback</code></td>
                                <td>Slide change callback</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-5 so-mb-3">CSS Classes</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead class="so-table-light">
                            <tr>
                                <th>Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td><code>.so-carousel</code></td><td>Base carousel container</td></tr>
                            <tr><td><code>.so-carousel-inner</code></td><td>Slides track/wrapper</td></tr>
                            <tr><td><code>.so-carousel-slide</code></td><td>Individual slide</td></tr>
                            <tr><td><code>.so-carousel-control</code></td><td>Navigation button base</td></tr>
                            <tr><td><code>.so-carousel-control-prev</code></td><td>Previous button</td></tr>
                            <tr><td><code>.so-carousel-control-next</code></td><td>Next button</td></tr>
                            <tr><td><code>.so-carousel-indicators</code></td><td>Indicators container</td></tr>
                            <tr><td><code>.so-carousel-indicator</code></td><td>Individual indicator</td></tr>
                            <tr><td><code>.so-carousel-caption</code></td><td>Caption overlay</td></tr>
                            <tr><td><code>.so-carousel-fade</code></td><td>Crossfade transition</td></tr>
                            <tr><td><code>.so-carousel-multi</code></td><td>Multi-item carousel</td></tr>
                            <tr><td><code>.so-carousel-autoplay</code></td><td>Autoplay with progress</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// SOCarousel Class
class SOCarousel {
    static instances = new Map();

    static DEFAULTS = {
        autoplay: false,
        interval: 5000,
        loop: true,
        pauseOnHover: true,
        keyboard: true,
        touch: true,
        items: 1
    };

    constructor(element, options = {}) {
        if (!(element instanceof HTMLElement)) return;
        if (SOCarousel.instances.has(element)) return SOCarousel.instances.get(element);

        this.element = element;
        this.inner = element.querySelector('.so-carousel-inner');
        this.slides = Array.from(element.querySelectorAll('.so-carousel-slide'));
        this.prevBtn = element.querySelector('.so-carousel-control-prev');
        this.nextBtn = element.querySelector('.so-carousel-control-next');
        this.indicators = Array.from(element.querySelectorAll('.so-carousel-indicator'));
        this.progressBar = element.querySelector('.so-carousel-progress-bar');

        this.options = {
            ...SOCarousel.DEFAULTS,
            autoplay: element.dataset.soAutoplay === 'true',
            interval: parseInt(element.dataset.soInterval) || SOCarousel.DEFAULTS.interval,
            loop: element.dataset.soLoop !== 'false',
            pauseOnHover: element.dataset.soPauseOnHover !== 'false',
            keyboard: element.dataset.soKeyboard !== 'false',
            touch: element.dataset.soTouch !== 'false',
            items: parseInt(element.dataset.soItems) || SOCarousel.DEFAULTS.items,
            ...options
        };

        this.currentIndex = 0;
        this.isPlaying = false;
        this.isPaused = false;
        this.isManuallyPaused = false;
        this.isSliding = false;
        this.autoplayTimer = null;
        this.touchStartX = 0;
        this.touchCurrentX = 0;
        this.isDragging = false;

        this._init();
        SOCarousel.instances.set(element, this);
    }

    static getInstance(element) { return SOCarousel.instances.get(element); }
    static initAll() { document.querySelectorAll('[data-so-carousel]').forEach(el => { if (!SOCarousel.instances.has(el)) new SOCarousel(el); }); }

    _init() {
        this._findInitialSlide();
        this._bindEvents();
        this._updateIndicators();
        requestAnimationFrame(() => this._updateTransform());
        if (this.options.autoplay) this.play();
        this.element.style.setProperty('--carousel-interval', `${this.options.interval}ms`);
    }

    _findInitialSlide() {
        const activeIndex = this.slides.findIndex(s => s.classList.contains('so-active'));
        this.currentIndex = activeIndex >= 0 ? activeIndex : 0;
        if (activeIndex < 0 && this.slides.length > 0) this.slides[0].classList.add('so-active');
    }

    _bindEvents() {
        if (this.prevBtn) this.prevBtn.addEventListener('click', (e) => { e.preventDefault(); this.prev(); });
        if (this.nextBtn) this.nextBtn.addEventListener('click', (e) => { e.preventDefault(); this.next(); });
        this.indicators.forEach((indicator, index) => indicator.addEventListener('click', () => this.goTo(index)));
        if (this.options.keyboard) { this.element.setAttribute('tabindex', '0'); this.element.addEventListener('keydown', (e) => this._handleKeydown(e)); }
        if (this.options.touch && this.inner) {
            this.inner.addEventListener('touchstart', (e) => this._handleTouchStart(e), { passive: true });
            this.inner.addEventListener('touchmove', (e) => this._handleTouchMove(e), { passive: false });
            this.inner.addEventListener('touchend', () => this._handleTouchEnd());
            this.inner.addEventListener('mousedown', (e) => this._handleMouseDown(e));
        }
        if (this.options.pauseOnHover) {
            this.element.addEventListener('mouseenter', () => { if (this.isPlaying && !this.isManuallyPaused) this._pauseAutoplay(true); });
            this.element.addEventListener('mouseleave', () => { if (this.isPlaying && this.isPaused && !this.isManuallyPaused) this._resumeAutoplay(); });
        }
    }

    _handleKeydown(e) {
        switch (e.key) {
            case 'ArrowLeft': e.preventDefault(); this.prev(); break;
            case 'ArrowRight': e.preventDefault(); this.next(); break;
        }
    }

    _handleTouchStart(e) { if (this.isSliding) return; this.touchStartX = e.touches[0].clientX; this.touchCurrentX = this.touchStartX; this.isDragging = true; }
    _handleTouchMove(e) { if (!this.isDragging) return; this.touchCurrentX = e.touches[0].clientX; if (Math.abs(this.touchCurrentX - this.touchStartX) > 10) e.preventDefault(); }
    _handleTouchEnd() { if (!this.isDragging) return; this.isDragging = false; const diff = this.touchCurrentX - this.touchStartX; if (Math.abs(diff) > 50) diff > 0 ? this.prev() : this.next(); }
    _handleMouseDown(e) {
        if (e.button !== 0) return;
        this.touchStartX = e.clientX; this.touchCurrentX = e.clientX; this.isDragging = true;
        const handleMouseMove = (e) => { this.touchCurrentX = e.clientX; };
        const handleMouseUp = () => { document.removeEventListener('mousemove', handleMouseMove); document.removeEventListener('mouseup', handleMouseUp); this.isDragging = false; const diff = this.touchCurrentX - this.touchStartX; if (Math.abs(diff) > 50) diff > 0 ? this.prev() : this.next(); };
        document.addEventListener('mousemove', handleMouseMove); document.addEventListener('mouseup', handleMouseUp);
    }

    next() { if (this.isSliding) return this; let nextIndex = this.currentIndex + 1; if (nextIndex >= this.slides.length) nextIndex = this.options.loop ? 0 : this.slides.length - 1; if (nextIndex !== this.currentIndex) this.goTo(nextIndex); return this; }
    prev() { if (this.isSliding) return this; let prevIndex = this.currentIndex - 1; if (prevIndex < 0) prevIndex = this.options.loop ? this.slides.length - 1 : 0; if (prevIndex !== this.currentIndex) this.goTo(prevIndex); return this; }

    goTo(index) {
        if (this.isSliding || index === this.currentIndex) return this;
        if (index < 0 || index >= this.slides.length) return this;
        const prevIndex = this.currentIndex;
        const direction = index > prevIndex ? 'next' : 'prev';
        this.isSliding = true;
        this.slides[prevIndex].classList.remove('so-active'); this.slides[index].classList.add('so-active'); this.currentIndex = index;
        this._updateIndicators(); this._resetProgress(); this._updateTransform();
        setTimeout(() => {
            this.isSliding = false;
            if (this.isPlaying && !this.isPaused) this._resetAutoplayTimer();
        }, 600);
        return this;
    }

    _updateTransform() {
        if (!this.inner) return;
        const isFade = this.element.classList.contains('so-carousel-fade');
        const isMulti = this.element.classList.contains('so-carousel-multi');
        if (isFade) return;
        if (isMulti) { const slide = this.slides[this.currentIndex]; if (slide) { const slideOffset = slide.offsetLeft; this.inner.style.transform = `translateX(-${slideOffset}px)`; } }
        else { this.inner.style.transform = `translateX(-${this.currentIndex * 100}%)`; }
    }

    _updateIndicators() { this.indicators.forEach((ind, i) => ind.classList.toggle('so-active', i === this.currentIndex)); }
    _resetProgress() { if (this.progressBar) { this.progressBar.style.animation = 'none'; this.progressBar.offsetHeight; this.progressBar.style.animation = ''; } }
    play() { if (this.slides.length <= 1) return this; this.isPlaying = true; this.isPaused = false; this.isManuallyPaused = false; this._resetAutoplayTimer(); this.element.classList.remove('so-paused'); return this; }
    pause() { this.isManuallyPaused = true; this._pauseAutoplay(true); return this; }
    stop() { this.isPlaying = false; this.isPaused = false; this.isManuallyPaused = false; if (this.autoplayTimer) { clearInterval(this.autoplayTimer); this.autoplayTimer = null; } return this; }
    _pauseAutoplay(updateState = true) { if (updateState) this.isPaused = true; if (this.autoplayTimer) { clearInterval(this.autoplayTimer); this.autoplayTimer = null; } this.element.classList.add('so-paused'); }
    _resumeAutoplay() { this.isPaused = false; this.element.classList.remove('so-paused'); this._resetAutoplayTimer(); }
    _resetAutoplayTimer() { if (this.autoplayTimer) clearInterval(this.autoplayTimer); if (this.options.interval > 0 && this.isPlaying && !this.isPaused) this.autoplayTimer = setInterval(() => this.next(), this.options.interval); }
    getCurrentIndex() { return this.currentIndex; }
    getSlideCount() { return this.slides.length; }
}

document.addEventListener('DOMContentLoaded', function() {
    SOCarousel.initAll();

    // Autoplay control buttons
    const autoplayCarousel = SOCarousel.getInstance(document.getElementById('autoplay-demo-carousel'));
    const playBtn = document.getElementById('autoplay-play-btn');
    const pauseBtn = document.getElementById('autoplay-pause-btn');
    if (playBtn && autoplayCarousel) playBtn.addEventListener('click', () => autoplayCarousel.play());
    if (pauseBtn && autoplayCarousel) pauseBtn.addEventListener('click', () => autoplayCarousel.pause());

    // API control buttons
    const apiCarousel = SOCarousel.getInstance(document.getElementById('api-demo-carousel'));
    if (apiCarousel) {
        document.getElementById('api-prev-btn')?.addEventListener('click', () => apiCarousel.prev());
        document.getElementById('api-next-btn')?.addEventListener('click', () => apiCarousel.next());
        document.getElementById('api-goto-0')?.addEventListener('click', () => apiCarousel.goTo(0));
        document.getElementById('api-goto-1')?.addEventListener('click', () => apiCarousel.goTo(1));
        document.getElementById('api-goto-2')?.addEventListener('click', () => apiCarousel.goTo(2));
        document.getElementById('api-goto-3')?.addEventListener('click', () => apiCarousel.goTo(3));
        document.getElementById('api-get-index')?.addEventListener('click', () => alert('Current: ' + (apiCarousel.getCurrentIndex() + 1)));
    }
});
</script>

<?php require_once '../../includes/footer.php'; ?>
