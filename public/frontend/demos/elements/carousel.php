<?php
/**
 * SixOrbit UI Demo - Carousel
 */
$pageTitle = 'Carousel';
$pageDescription = 'Carousel/slider component';

require_once '../includes/config.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/navbar.php';
?>

<!-- Main Content -->
<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Carousel</h1>
            <p class="so-page-subtitle">Carousel/slider component</p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">
<div class="so-grid so-grid-cols-1 so-gap-6">

        <!-- Basic Carousel -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Carousel</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">A simple image carousel with navigation controls and indicators.</p>

                <div class="so-carousel" data-so-carousel id="basic-carousel">
                            <div class="so-carousel-inner">
                                <div class="so-carousel-slide so-active">
                                    <img src="https://picsum.photos/800/400?random=1" alt="Slide 1">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/400?random=2" alt="Slide 2">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/400?random=3" alt="Slide 3">
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
                <?= so_code_tabs('carousel-basic', [
                    ['language' => 'html', 'code' => '<div class="so-carousel" data-so-carousel>
    <div class="so-carousel-inner">
        <div class="so-carousel-slide so-active">
            <img src="slide1.jpg" alt="Slide 1">
        </div>
        <div class="so-carousel-slide">
            <img src="slide2.jpg" alt="Slide 2">
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
    </div>
</div>'],
                    ['language' => 'javascript', 'code' => '// Auto-initialized with data-so-carousel attribute
// Or initialize manually:
const carousel = new SOCarousel(document.getElementById(\'my-carousel\'), {
    autoplay: false,
    interval: 5000,
    loop: true
});

// Navigate programmatically
carousel.next();
carousel.prev();
carousel.goTo(2);']
                ]) ?>
            </div>
        </div>

        <!-- Carousel with Captions -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Carousel with Captions</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Add captions with gradient overlay to provide context for each slide.</p>

                <div class="so-carousel" data-so-carousel id="caption-carousel">
                            <div class="so-carousel-inner">
                                <div class="so-carousel-slide so-active">
                                    <img src="https://picsum.photos/800/450?random=4" alt="Mountains">
                                    <div class="so-carousel-caption">
                                        <h4 class="so-carousel-caption-title">Mountain Adventure</h4>
                                        <p class="so-carousel-caption-text">Explore the beauty of nature's majestic peaks.</p>
                                    </div>
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/450?random=5" alt="Ocean">
                                    <div class="so-carousel-caption">
                                        <h4 class="so-carousel-caption-title">Ocean Dreams</h4>
                                        <p class="so-carousel-caption-text">Discover the tranquility of endless horizons.</p>
                                    </div>
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/450?random=6" alt="Forest">
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
                <?= so_code_block('<div class="so-carousel-slide so-active">
    <img src="image.jpg" alt="Description">
    <div class="so-carousel-caption">
        <h4 class="so-carousel-caption-title">Slide Title</h4>
        <p class="so-carousel-caption-text">Slide description text.</p>
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Fade Transition -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Fade Transition</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Use <code>.so-carousel-fade</code> for a crossfade effect instead of sliding.</p>

                <div class="so-carousel so-carousel-fade" data-so-carousel id="fade-carousel">
                            <div class="so-carousel-inner">
                                <div class="so-carousel-slide so-active">
                                    <img src="https://picsum.photos/800/400?random=7" alt="Slide 1">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/400?random=8" alt="Slide 2">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/400?random=9" alt="Slide 3">
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
                <?= so_code_block('<div class="so-carousel so-carousel-fade" data-so-carousel>
    <!-- slides... -->
</div>

<!-- Line-style indicators -->
<div class="so-carousel-indicators so-carousel-indicators-line">
    <button class="so-carousel-indicator so-active"></button>
    <button class="so-carousel-indicator"></button>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Multi-Item Carousel -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Multi-Item Carousel</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Display multiple items at once using <code>.so-carousel-multi</code>. Perfect for product carousels or card galleries.</p>

                <div class="so-carousel so-carousel-multi so-carousel-cards" data-so-carousel data-so-items="3" id="multi-carousel">
                            <div class="so-carousel-inner">
                                <div class="so-carousel-slide so-active">
                                    <div class="so-card">
                                        <img src="https://picsum.photos/400/250?random=10" alt="Product 1" style="width:100%; border-radius: 8px 8px 0 0;">
                                        <div class="so-card-body">
                                            <h5 class="so-card-title">Product One</h5>
                                            <p class="so-text-muted">Starting at $99</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="so-carousel-slide">
                                    <div class="so-card">
                                        <img src="https://picsum.photos/400/250?random=11" alt="Product 2" style="width:100%; border-radius: 8px 8px 0 0;">
                                        <div class="so-card-body">
                                            <h5 class="so-card-title">Product Two</h5>
                                            <p class="so-text-muted">Starting at $149</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="so-carousel-slide">
                                    <div class="so-card">
                                        <img src="https://picsum.photos/400/250?random=12" alt="Product 3" style="width:100%; border-radius: 8px 8px 0 0;">
                                        <div class="so-card-body">
                                            <h5 class="so-card-title">Product Three</h5>
                                            <p class="so-text-muted">Starting at $199</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="so-carousel-slide">
                                    <div class="so-card">
                                        <img src="https://picsum.photos/400/250?random=13" alt="Product 4" style="width:100%; border-radius: 8px 8px 0 0;">
                                        <div class="so-card-body">
                                            <h5 class="so-card-title">Product Four</h5>
                                            <p class="so-text-muted">Starting at $249</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="so-carousel-slide">
                                    <div class="so-card">
                                        <img src="https://picsum.photos/400/250?random=14" alt="Product 5" style="width:100%; border-radius: 8px 8px 0 0;">
                                        <div class="so-card-body">
                                            <h5 class="so-card-title">Product Five</h5>
                                            <p class="so-text-muted">Starting at $299</p>
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
                <?= so_code_tabs('carousel-multi', [
                    ['language' => 'html', 'code' => '<div class="so-carousel so-carousel-multi so-carousel-cards" data-so-carousel data-so-items="3">
    <div class="so-carousel-inner">
        <div class="so-carousel-slide so-active">
            <div class="so-card">...</div>
        </div>
        <div class="so-carousel-slide">
            <div class="so-card">...</div>
        </div>
        <!-- more slides... -->
    </div>
    <!-- controls... -->
</div>'],
                    ['language' => 'javascript', 'code' => '// Multi-item carousel with responsive items
const carousel = new SOCarousel(element, {
    itemsVisible: 3,           // Show 3 items at once
    itemsToScroll: 1,          // Scroll 1 item at a time
    responsive: {
        768: { itemsVisible: 2 },  // 2 items on tablet
        480: { itemsVisible: 1 }   // 1 item on mobile
    }
});']
                ]) ?>
            </div>
        </div>

        <!-- Hero Carousel -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Hero Carousel (Center with Peek)</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Material Design inspired hero carousel showing edges of adjacent slides.</p>

                <div class="so-carousel so-carousel-hero" data-so-carousel id="hero-carousel">
                            <div class="so-carousel-inner">
                                <div class="so-carousel-slide so-active">
                                    <img src="https://picsum.photos/900/500?random=15" alt="Hero 1">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/900/500?random=16" alt="Hero 2">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/900/500?random=17" alt="Hero 3">
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
                <?= so_code_block('<div class="so-carousel so-carousel-hero" data-so-carousel>
    <div class="so-carousel-inner">
        <div class="so-carousel-slide so-active">
            <img src="hero1.jpg" alt="Hero 1">
        </div>
        <!-- more slides... -->
    </div>
    <!-- controls and indicators... -->
</div>', 'html') ?>
            </div>
        </div>

        <!-- Gallery with Thumbnails -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Gallery with Thumbnails</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">A gallery-style carousel with thumbnail navigation below.</p>

                <div class="so-carousel-gallery">
                            <div class="so-carousel" data-so-carousel id="gallery-carousel">
                                <div class="so-carousel-inner">
                                    <div class="so-carousel-slide so-active">
                                        <img src="https://picsum.photos/800/500?random=18" alt="Gallery 1">
                                    </div>
                                    <div class="so-carousel-slide">
                                        <img src="https://picsum.photos/800/500?random=19" alt="Gallery 2">
                                    </div>
                                    <div class="so-carousel-slide">
                                        <img src="https://picsum.photos/800/500?random=20" alt="Gallery 3">
                                    </div>
                                    <div class="so-carousel-slide">
                                        <img src="https://picsum.photos/800/500?random=21" alt="Gallery 4">
                                    </div>
                                    <div class="so-carousel-slide">
                                        <img src="https://picsum.photos/800/500?random=22" alt="Gallery 5">
                                    </div>
                                </div>

                                <button class="so-carousel-control so-carousel-control-prev" aria-label="Previous">
                                    <span class="material-icons">chevron_left</span>
                                </button>
                                <button class="so-carousel-control so-carousel-control-next" aria-label="Next">
                                    <span class="material-icons">chevron_right</span>
                                </button>
                            </div>

                            <div class="so-carousel-thumbnails">
                                <button class="so-carousel-thumbnail so-active" data-so-slide="0">
                                    <img src="https://picsum.photos/800/500?random=18" alt="Thumb 1">
                                </button>
                                <button class="so-carousel-thumbnail" data-so-slide="1">
                                    <img src="https://picsum.photos/800/500?random=19" alt="Thumb 2">
                                </button>
                                <button class="so-carousel-thumbnail" data-so-slide="2">
                                    <img src="https://picsum.photos/800/500?random=20" alt="Thumb 3">
                                </button>
                                <button class="so-carousel-thumbnail" data-so-slide="3">
                                    <img src="https://picsum.photos/800/500?random=21" alt="Thumb 4">
                                </button>
                                <button class="so-carousel-thumbnail" data-so-slide="4">
                                    <img src="https://picsum.photos/800/500?random=22" alt="Thumb 5">
                                </button>
                            </div>
                </div>
                <?= so_code_block('<div class="so-carousel-gallery">
    <div class="so-carousel" data-so-carousel>
        <!-- main carousel... -->
    </div>

    <div class="so-carousel-thumbnails">
        <button class="so-carousel-thumbnail so-active" data-so-slide="0">
            <img src="thumb1.jpg" alt="Thumbnail 1">
        </button>
        <button class="so-carousel-thumbnail" data-so-slide="1">
            <img src="thumb2.jpg" alt="Thumbnail 2">
        </button>
        <!-- more thumbnails... -->
    </div>
</div>', 'html') ?>
            </div>
        </div>

        <!-- Autoplay with Progress -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Autoplay with Progress</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Automatically advance slides with a visual progress indicator. Pauses on hover.</p>

                <div class="so-carousel so-carousel-autoplay" data-so-carousel data-so-autoplay="true" data-so-interval="4000" id="autoplay-carousel">
                            <div class="so-carousel-inner">
                                <div class="so-carousel-slide so-active">
                                    <img src="https://picsum.photos/800/400?random=23" alt="Auto 1">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/400?random=24" alt="Auto 2">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/400?random=25" alt="Auto 3">
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

                        <div class="so-d-flex so-gap-2 so-mt-4">
                            <button class="so-btn so-btn-sm so-btn-primary" id="autoplay-play-btn">
                                <span class="material-icons">play_arrow</span> Play
                            </button>
                            <button class="so-btn so-btn-sm so-btn-outline-secondary" id="autoplay-pause-btn">
                                <span class="material-icons">pause</span> Pause
                            </button>
                </div>
                <?= so_code_tabs('autoplay', [
                    ['language' => 'html', 'code' => '<div class="so-carousel so-carousel-autoplay"
     data-so-carousel
     data-so-autoplay="true"
     data-so-interval="4000">
    <!-- slides... -->

    <div class="so-carousel-progress">
        <div class="so-carousel-progress-bar"></div>
    </div>
</div>'],
                    ['language' => 'javascript', 'code' => '// Initialize with autoplay
const carousel = new SOCarousel(element, {
    autoplay: true,
    interval: 4000,    // 4 seconds between slides
    pauseOnHover: true // Pause when mouse hovers
});

// Control autoplay programmatically
carousel.play();   // Start autoplay
carousel.pause();  // Pause autoplay
carousel.stop();   // Stop and reset']
                ]) ?>
            </div>
        </div>

        <!-- Controls Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Controls Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Different control visibility and position options.</p>

                <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4">
                    <!-- Hover Controls -->
                            <div>
                                <label class="so-slider-label so-mb-2">Hover to Show Controls</label>
                                <div class="so-carousel so-carousel-controls-hover" data-so-carousel>
                                    <div class="so-carousel-inner">
                                        <div class="so-carousel-slide so-active">
                                            <img src="https://picsum.photos/400/250?random=26" alt="Hover 1">
                                        </div>
                                        <div class="so-carousel-slide">
                                            <img src="https://picsum.photos/400/250?random=27" alt="Hover 2">
                                        </div>
                                    </div>
                                    <button class="so-carousel-control so-carousel-control-prev"><span class="material-icons">chevron_left</span></button>
                                    <button class="so-carousel-control so-carousel-control-next"><span class="material-icons">chevron_right</span></button>
                                </div>
                            </div>

                            <!-- Dark Controls -->
                            <div>
                                <label class="so-slider-label so-mb-2">Dark Controls</label>
                                <div class="so-carousel so-carousel-dark" data-so-carousel>
                                    <div class="so-carousel-inner">
                                        <div class="so-carousel-slide so-active">
                                            <img src="https://picsum.photos/400/250?random=28" alt="Dark 1">
                                        </div>
                                        <div class="so-carousel-slide">
                                            <img src="https://picsum.photos/400/250?random=29" alt="Dark 2">
                                        </div>
                                    </div>
                                    <button class="so-carousel-control so-carousel-control-prev"><span class="material-icons">chevron_left</span></button>
                                    <button class="so-carousel-control so-carousel-control-next"><span class="material-icons">chevron_right</span></button>
                                    <div class="so-carousel-indicators">
                                        <button class="so-carousel-indicator so-active" data-so-slide="0"></button>
                                        <button class="so-carousel-indicator" data-so-slide="1"></button>
                                    </div>
                                </div>
                            </div>
                </div>
                <?= so_code_block('<!-- Show controls on hover -->
<div class="so-carousel so-carousel-controls-hover">...</div>

<!-- Dark controls -->
<div class="so-carousel so-carousel-dark">...</div>

<!-- Controls inside (closer to edges) -->
<div class="so-carousel so-carousel-controls-inside">...</div>

<!-- Controls outside (with padding) -->
<div class="so-carousel so-carousel-controls-outside">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Size Variants -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Size Variants</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Adjust control sizes with <code>.so-carousel-sm</code> or <code>.so-carousel-lg</code>.</p>

                <div class="so-grid so-grid-cols-1 md:so-grid-cols-2 so-gap-4">
                    <!-- Small -->
                            <div>
                                <label class="so-slider-label so-mb-2">Small (.so-carousel-sm)</label>
                                <div class="so-carousel so-carousel-sm" data-so-carousel>
                                    <div class="so-carousel-inner">
                                        <div class="so-carousel-slide so-active">
                                            <img src="https://picsum.photos/400/250?random=30" alt="Small 1">
                                        </div>
                                        <div class="so-carousel-slide">
                                            <img src="https://picsum.photos/400/250?random=31" alt="Small 2">
                                        </div>
                                    </div>
                                    <button class="so-carousel-control so-carousel-control-prev"><span class="material-icons">chevron_left</span></button>
                                    <button class="so-carousel-control so-carousel-control-next"><span class="material-icons">chevron_right</span></button>
                                </div>
                            </div>

                            <!-- Large -->
                            <div>
                                <label class="so-slider-label so-mb-2">Large (.so-carousel-lg)</label>
                                <div class="so-carousel so-carousel-lg" data-so-carousel>
                                    <div class="so-carousel-inner">
                                        <div class="so-carousel-slide so-active">
                                            <img src="https://picsum.photos/400/250?random=32" alt="Large 1">
                                        </div>
                                        <div class="so-carousel-slide">
                                            <img src="https://picsum.photos/400/250?random=33" alt="Large 2">
                                        </div>
                                    </div>
                                    <button class="so-carousel-control so-carousel-control-prev"><span class="material-icons">chevron_left</span></button>
                                    <button class="so-carousel-control so-carousel-control-next"><span class="material-icons">chevron_right</span></button>
                                </div>
                            </div>
                </div>
                <?= so_code_block('<div class="so-carousel so-carousel-sm">...</div>
<div class="so-carousel so-carousel-lg">...</div>', 'html') ?>
            </div>
        </div>

        <!-- Programmatic Controls -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Programmatic Controls</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Control carousels via JavaScript API.</p>

                <div class="so-carousel" data-so-carousel id="api-carousel">
                            <div class="so-carousel-inner">
                                <div class="so-carousel-slide so-active">
                                    <img src="https://picsum.photos/800/350?random=34" alt="API 1">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/350?random=35" alt="API 2">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/350?random=36" alt="API 3">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/350?random=37" alt="API 4">
                                </div>
                            </div>
                            <div class="so-carousel-indicators">
                                <button class="so-carousel-indicator so-active" data-so-slide="0"></button>
                                <button class="so-carousel-indicator" data-so-slide="1"></button>
                                <button class="so-carousel-indicator" data-so-slide="2"></button>
                                <button class="so-carousel-indicator" data-so-slide="3"></button>
                            </div>
                        </div>

                        <div class="so-d-flex so-flex-wrap so-gap-2 so-mt-4">
                            <button class="so-btn so-btn-sm so-btn-primary" onclick="apiCarousel.prev()">
                                <span class="material-icons">chevron_left</span> Prev
                            </button>
                            <button class="so-btn so-btn-sm so-btn-primary" onclick="apiCarousel.next()">
                                Next <span class="material-icons">chevron_right</span>
                            </button>
                            <button class="so-btn so-btn-sm so-btn-outline-secondary" onclick="apiCarousel.goTo(0)">Go to 1</button>
                            <button class="so-btn so-btn-sm so-btn-outline-secondary" onclick="apiCarousel.goTo(1)">Go to 2</button>
                            <button class="so-btn so-btn-sm so-btn-outline-secondary" onclick="apiCarousel.goTo(2)">Go to 3</button>
                            <button class="so-btn so-btn-sm so-btn-outline-secondary" onclick="apiCarousel.goTo(3)">Go to 4</button>
                            <button class="so-btn so-btn-sm so-btn-outline-info" onclick="alert('Current: ' + (apiCarousel.getCurrentIndex() + 1))">Get Index</button>
                </div>
                <?= so_code_block('// Get carousel instance
const carousel = SOCarousel.getInstance(document.getElementById(\'my-carousel\'));

// Navigate
carousel.next();           // Go to next slide
carousel.prev();           // Go to previous slide
carousel.goTo(2);          // Go to slide at index 2

// Autoplay control
carousel.play();           // Start autoplay
carousel.pause();          // Pause autoplay
carousel.stop();           // Stop autoplay completely

// Get state
carousel.getCurrentIndex(); // Get current slide index
carousel.getSlideCount();   // Get total number of slides
carousel.isPlaying();       // Check if autoplay is active

// Destroy instance
carousel.destroy();', 'javascript') ?>
            </div>
        </div>

        <!-- Events -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Events</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Carousels emit events for slide transitions. Try navigating the carousel below.</p>

                <div class="so-carousel" data-so-carousel id="events-carousel">
                            <div class="so-carousel-inner">
                                <div class="so-carousel-slide so-active">
                                    <img src="https://picsum.photos/800/350?random=38" alt="Event 1">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/350?random=39" alt="Event 2">
                                </div>
                                <div class="so-carousel-slide">
                                    <img src="https://picsum.photos/800/350?random=40" alt="Event 3">
                                </div>
                            </div>
                            <button class="so-carousel-control so-carousel-control-prev"><span class="material-icons">chevron_left</span></button>
                            <button class="so-carousel-control so-carousel-control-next"><span class="material-icons">chevron_right</span></button>
                            <div class="so-carousel-indicators">
                                <button class="so-carousel-indicator so-active" data-so-slide="0"></button>
                                <button class="so-carousel-indicator" data-so-slide="1"></button>
                                <button class="so-carousel-indicator" data-so-slide="2"></button>
                            </div>
                        </div>

                        <div class="so-alert so-alert-info so-mt-4" id="carousel-event-log">
                            <span class="material-icons">info</span>
                            <span>Event log will appear here. Navigate the carousel above.</span>
                </div>
                <?= so_code_block('const carouselEl = document.getElementById(\'my-carousel\');

// Before slide changes (cancelable)
carouselEl.addEventListener(\'so:carousel:slide\', (e) => {
    console.log(\'Sliding from\', e.detail.from, \'to\', e.detail.to);
    // e.preventDefault(); // Cancel the slide
});

// After slide transition completes
carouselEl.addEventListener(\'so:carousel:slid\', (e) => {
    console.log(\'Slid to slide\', e.detail.to);
});

// Autoplay events
carouselEl.addEventListener(\'so:carousel:play\', () => {
    console.log(\'Autoplay started\');
});

carouselEl.addEventListener(\'so:carousel:pause\', () => {
    console.log(\'Autoplay so-paused\');
});', 'javascript') ?>

                <h5 class="so-mt-6 so-mb-3">Available Events</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Description</th>
                                <th>Detail Properties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>so:carousel:slide</code></td>
                                <td>Before slide change (cancelable)</td>
                                <td><code>{ from, to, direction }</code></td>
                            </tr>
                            <tr>
                                <td><code>so:carousel:slid</code></td>
                                <td>After slide transition completes</td>
                                <td><code>{ from, to, direction }</code></td>
                            </tr>
                            <tr>
                                <td><code>so:carousel:play</code></td>
                                <td>Autoplay started/resumed</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td><code>so:carousel:pause</code></td>
                                <td>Autoplay so-paused</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Options -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">Options</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Configure carousels using data attributes or JavaScript options.</p>

                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Option</th>
                                <th>Data Attribute</th>
                                <th>Type</th>
                                <th>Default</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>autoplay</code></td>
                                <td><code>data-so-autoplay</code></td>
                                <td>boolean</td>
                                <td><code>false</code></td>
                                <td>Start autoplay automatically</td>
                            </tr>
                            <tr>
                                <td><code>interval</code></td>
                                <td><code>data-so-interval</code></td>
                                <td>number</td>
                                <td><code>5000</code></td>
                                <td>Autoplay interval in milliseconds</td>
                            </tr>
                            <tr>
                                <td><code>loop</code></td>
                                <td><code>data-so-loop</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Loop back to start/end</td>
                            </tr>
                            <tr>
                                <td><code>pauseOnHover</code></td>
                                <td><code>data-so-pause-on-hover</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Pause autoplay on mouse hover</td>
                            </tr>
                            <tr>
                                <td><code>keyboard</code></td>
                                <td><code>data-so-keyboard</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Enable keyboard navigation</td>
                            </tr>
                            <tr>
                                <td><code>touch</code></td>
                                <td><code>data-so-touch</code></td>
                                <td>boolean</td>
                                <td><code>true</code></td>
                                <td>Enable touch/swipe gestures</td>
                            </tr>
                            <tr>
                                <td><code>items</code></td>
                                <td><code>data-so-items</code></td>
                                <td>number</td>
                                <td><code>1</code></td>
                                <td>Visible items (for multi-item)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <?= so_code_block('// Initialize with options
const carousel = new SOCarousel(element, {
    autoplay: true,
    interval: 4000,
    loop: true,
    pauseOnHover: true,
    keyboard: true,
    touch: true
});

// Or use data attributes
<div class="so-carousel"
     data-so-carousel
     data-so-autoplay="true"
     data-so-interval="4000">
    ...
</div>', 'javascript') ?>
            </div>
        </div>

        <!-- CSS Classes Reference -->
        <div class="so-card">
            <div class="so-card-header">
                <h3 class="so-card-title">CSS Classes Reference</h3>
            </div>
            <div class="so-card-body">
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
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
                            <tr><td><code>.so-carousel-indicator</code></td><td>Individual indicator dot</td></tr>
                            <tr><td><code>.so-carousel-indicators-line</code></td><td>Line-style indicators</td></tr>
                            <tr><td><code>.so-carousel-caption</code></td><td>Caption overlay</td></tr>
                            <tr><td><code>.so-carousel-fade</code></td><td>Crossfade transition variant</td></tr>
                            <tr><td><code>.so-carousel-multi</code></td><td>Multi-item carousel</td></tr>
                            <tr><td><code>.so-carousel-hero</code></td><td>Hero with peek effect</td></tr>
                            <tr><td><code>.so-carousel-gallery</code></td><td>Gallery layout wrapper</td></tr>
                            <tr><td><code>.so-carousel-thumbnails</code></td><td>Thumbnails container</td></tr>
                            <tr><td><code>.so-carousel-thumbnail</code></td><td>Individual thumbnail</td></tr>
                            <tr><td><code>.so-carousel-sm</code></td><td>Small size variant</td></tr>
                            <tr><td><code>.so-carousel-lg</code></td><td>Large size variant</td></tr>
                            <tr><td><code>.so-carousel-dark</code></td><td>Dark controls variant</td></tr>
                            <tr><td><code>.so-carousel-controls-hover</code></td><td>Show controls on hover only</td></tr>
                            <tr><td><code>.so-carousel-autoplay</code></td><td>Enables autoplay progress animation</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- UiEngine Usage Examples -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">UiEngine Usage Examples</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">The Carousel component is available in the UiEngine for both backend (PHP) and frontend (JavaScript) rendering.</p>

                <?= so_tabs('carousel-uiengine-examples', [
                    [
                        'id' => 'php-example',
                        'title' => 'PHP (Backend)',
                        'active' => true,
                        'content' => so_code_block('use Core\UiEngine\UiEngine;

// Basic carousel with autoplay
$carousel = UiEngine::carousel()
    ->id(\'my-carousel\')
    ->addSlide(\'image1.jpg\', \'First Slide\', \'Slide description\', \'Alt text\')
    ->addSlide(\'image2.jpg\', \'Second Slide\', \'Another description\')
    ->addSlide(\'image3.jpg\', \'Third Slide\')
    ->autoplay(true)
    ->interval(4000)
    ->render();

// Hero carousel with fade
$heroCarousel = UiEngine::carousel()
    ->addSlide(\'hero1.jpg\')
    ->addSlide(\'hero2.jpg\')
    ->addSlide(\'hero3.jpg\')
    ->hero()
    ->fade()
    ->dark()
    ->render();

// Multi-item carousel
$productsCarousel = UiEngine::carousel()
    ->addSlide(\'product1.jpg\')
    ->addSlide(\'product2.jpg\')
    ->addSlide(\'product3.jpg\')
    ->addSlide(\'product4.jpg\')
    ->multi(3)
    ->controlsHover()
    ->lineIndicators()
    ->render();

// Full configuration
$advancedCarousel = UiEngine::carousel()
    ->slides([
        [\'image\' => \'slide1.jpg\', \'title\' => \'Title 1\', \'description\' => \'Desc 1\'],
        [\'image\' => \'slide2.jpg\', \'title\' => \'Title 2\', \'description\' => \'Desc 2\'],
    ])
    ->indicators(true)
    ->controls(true)
    ->autoplay(true)
    ->interval(5000)
    ->fade(true)
    ->touch(true)
    ->pauseOnHover(true)
    ->keyboard(true)
    ->loop(true)
    ->dark()
    ->small()
    ->render();', 'php', false)
                    ],
                    [
                        'id' => 'js-example',
                        'title' => 'JavaScript (Frontend)',
                        'content' => so_code_block('import { UiEngine } from \'./ui-engine/UiEngine.js\';

// Basic carousel
const carousel = UiEngine.carousel()
    .id(\'my-carousel\')
    .addSlide(\'image1.jpg\', \'First Slide\', \'Description\', \'Alt text\')
    .addSlide(\'image2.jpg\', \'Second Slide\', \'Description\')
    .autoplay(true)
    .interval(4000)
    .render();

document.getElementById(\'container\').innerHTML = carousel;

// Hero carousel with chaining
const heroCarousel = UiEngine.carousel()
    .addSlide(\'hero1.jpg\')
    .addSlide(\'hero2.jpg\')
    .hero()
    .fade()
    .dark()
    .render();

// Multi-item carousel
const productsCarousel = UiEngine.carousel()
    .slides([
        { image: \'product1.jpg\' },
        { image: \'product2.jpg\' },
        { image: \'product3.jpg\' },
        { image: \'product4.jpg\' }
    ])
    .multi(3)
    .controlsHover()
    .lineIndicators()
    .render();

// Full configuration
const advancedCarousel = UiEngine.carousel()
    .slides([
        { image: \'slide1.jpg\', title: \'Title 1\', description: \'Desc 1\' },
        { image: \'slide2.jpg\', title: \'Title 2\', description: \'Desc 2\' }
    ])
    .autoplay(true)
    .interval(5000)
    .fade(true)
    .pauseOnHover(true)
    .keyboard(true)
    .loop(true)
    .dark()
    .small()
    .render();', 'javascript', false)
                    ],
                    [
                        'id' => 'html-example',
                        'title' => 'HTML (Static)',
                        'content' => so_code_block('<!-- Basic carousel -->
<div class="so-carousel" data-so-carousel>
    <div class="so-carousel-inner">
        <div class="so-carousel-slide so-active">
            <img src="slide1.jpg" alt="Slide 1">
        </div>
        <div class="so-carousel-slide">
            <img src="slide2.jpg" alt="Slide 2">
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
    </div>
</div>

<!-- Hero carousel with fade -->
<div class="so-carousel so-carousel-hero so-carousel-fade so-carousel-dark"
     data-so-carousel>
    <!-- slides... -->
</div>

<!-- Multi-item carousel -->
<div class="so-carousel so-carousel-multi so-carousel-controls-hover"
     data-so-carousel
     data-so-items="3">
    <div class="so-carousel-inner">
        <div class="so-carousel-slide so-active">...</div>
        <div class="so-carousel-slide">...</div>
        <div class="so-carousel-slide">...</div>
    </div>
    <div class="so-carousel-indicators so-carousel-indicators-line">
        <button class="so-carousel-indicator so-active"></button>
        <button class="so-carousel-indicator"></button>
        <button class="so-carousel-indicator"></button>
    </div>
</div>', 'html', false)
                    ]
                ]) ?>
            </div>
        </div>

        <!-- API Reference -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">API Reference</h3>
            </div>
            <div class="so-card-body">
                <?= so_tabs('carousel-api-reference', [
                    [
                        'id' => 'config-methods',
                        'title' => 'Configuration Methods',
                        'active' => true,
                        'content' => '
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%">Method</th>
                                            <th style="width: 25%">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>slides(array)</code></td>
                                            <td><code>array $slides</code></td>
                                            <td>Set all slides at once. Each slide: <code>[\'image\' => \'\', \'title\' => \'\', \'description\' => \'\', \'alt\' => \'\']</code></td>
                                        </tr>
                                        <tr>
                                            <td><code>addSlide()</code></td>
                                            <td><code>string $image</code><br><code>?string $title</code><br><code>?string $description</code><br><code>?string $alt</code></td>
                                            <td>Add a single slide with optional title, description, and alt text</td>
                                        </tr>
                                        <tr>
                                            <td><code>indicators()</code></td>
                                            <td><code>bool $show = true</code></td>
                                            <td>Show or hide slide indicators (dots)</td>
                                        </tr>
                                        <tr>
                                            <td><code>controls()</code></td>
                                            <td><code>bool $show = true</code></td>
                                            <td>Show or hide prev/next navigation buttons</td>
                                        </tr>
                                        <tr>
                                            <td><code>autoplay()</code></td>
                                            <td><code>bool $autoplay = true</code></td>
                                            <td>Enable automatic slide advancement</td>
                                        </tr>
                                        <tr>
                                            <td><code>interval()</code></td>
                                            <td><code>int $ms</code></td>
                                            <td>Set autoplay interval in milliseconds (default: 5000)</td>
                                        </tr>
                                        <tr>
                                            <td><code>fade()</code></td>
                                            <td><code>bool $fade = true</code></td>
                                            <td>Use crossfade transition instead of sliding</td>
                                        </tr>
                                        <tr>
                                            <td><code>touch()</code></td>
                                            <td><code>bool $touch = true</code></td>
                                            <td>Enable touch/swipe gestures for navigation</td>
                                        </tr>
                                        <tr>
                                            <td><code>pauseOnHover()</code></td>
                                            <td><code>bool $pause = true</code></td>
                                            <td>Pause autoplay when mouse hovers over carousel</td>
                                        </tr>
                                        <tr>
                                            <td><code>keyboard()</code></td>
                                            <td><code>bool $keyboard = true</code></td>
                                            <td>Enable keyboard navigation (arrow keys, Home, End, Space)</td>
                                        </tr>
                                        <tr>
                                            <td><code>loop()</code></td>
                                            <td><code>bool $loop = true</code></td>
                                            <td>Enable looping (wrap around to start/end)</td>
                                        </tr>
                                        <tr>
                                            <td><code>dark()</code></td>
                                            <td><code>bool $dark = true</code></td>
                                            <td>Use dark variant with dark controls for light backgrounds</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'variant-methods',
                        'title' => 'Carousel Variants',
                        'content' => '
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%">Method</th>
                                            <th style="width: 25%">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>hero()</code></td>
                                            <td>-</td>
                                            <td>Center-focused carousel with peek effect showing edges of adjacent slides</td>
                                        </tr>
                                        <tr>
                                            <td><code>multi()</code></td>
                                            <td><code>?int $items = null</code></td>
                                            <td>Multi-item carousel showing multiple slides at once. Specify number of visible items.</td>
                                        </tr>
                                        <tr>
                                            <td><code>small()</code></td>
                                            <td>-</td>
                                            <td>Smaller controls and indicators size</td>
                                        </tr>
                                        <tr>
                                            <td><code>large()</code></td>
                                            <td>-</td>
                                            <td>Larger controls and indicators size</td>
                                        </tr>
                                        <tr>
                                            <td><code>controlsHover()</code></td>
                                            <td>-</td>
                                            <td>Show controls only on hover (cleaner look)</td>
                                        </tr>
                                        <tr>
                                            <td><code>lineIndicators()</code></td>
                                            <td>-</td>
                                            <td>Use line-style indicators instead of dots</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'interactivity-js',
                        'title' => 'Interactivity (JS)',
                        'content' => '
                            <p class="so-text-muted so-mb-4">The SOCarousel JavaScript class provides runtime interactivity for carousels.</p>
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%">Method</th>
                                            <th style="width: 25%">Returns</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>next()</code></td>
                                            <td><code>this</code></td>
                                            <td>Navigate to next slide</td>
                                        </tr>
                                        <tr>
                                            <td><code>prev()</code></td>
                                            <td><code>this</code></td>
                                            <td>Navigate to previous slide</td>
                                        </tr>
                                        <tr>
                                            <td><code>goTo(index)</code></td>
                                            <td><code>this</code></td>
                                            <td>Navigate to specific slide by index (0-based)</td>
                                        </tr>
                                        <tr>
                                            <td><code>play()</code></td>
                                            <td><code>this</code></td>
                                            <td>Start autoplay</td>
                                        </tr>
                                        <tr>
                                            <td><code>pause()</code></td>
                                            <td><code>this</code></td>
                                            <td>Pause autoplay (can be resumed)</td>
                                        </tr>
                                        <tr>
                                            <td><code>stop()</code></td>
                                            <td><code>this</code></td>
                                            <td>Stop autoplay completely</td>
                                        </tr>
                                        <tr>
                                            <td><code>getCurrentIndex()</code></td>
                                            <td><code>number</code></td>
                                            <td>Get current slide index</td>
                                        </tr>
                                        <tr>
                                            <td><code>getSlideCount()</code></td>
                                            <td><code>number</code></td>
                                            <td>Get total number of slides</td>
                                        </tr>
                                        <tr>
                                            <td><code>isPlaying()</code></td>
                                            <td><code>boolean</code></td>
                                            <td>Check if autoplay is active</td>
                                        </tr>
                                        <tr>
                                            <td><code>destroy()</code></td>
                                            <td><code>void</code></td>
                                            <td>Destroy the carousel instance and cleanup</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="so-mt-4 so-mb-3">Static Methods</h5>
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%">Method</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>SOCarousel.getInstance(element)</code></td>
                                            <td>Get existing carousel instance from DOM element</td>
                                        </tr>
                                        <tr>
                                            <td><code>SOCarousel.initAll()</code></td>
                                            <td>Initialize all carousels with <code>data-so-carousel</code> attribute</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <h5 class="so-mt-4 so-mb-3">Events</h5>
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%">Event</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>so:carousel:slide</code></td>
                                            <td>Fires before slide change (cancelable). Detail: <code>{ from, to, direction }</code></td>
                                        </tr>
                                        <tr>
                                            <td><code>so:carousel:slid</code></td>
                                            <td>Fires after slide transition completes. Detail: <code>{ from, to, direction }</code></td>
                                        </tr>
                                        <tr>
                                            <td><code>so:carousel:play</code></td>
                                            <td>Fires when autoplay starts or resumes</td>
                                        </tr>
                                        <tr>
                                            <td><code>so:carousel:pause</code></td>
                                            <td>Fires when autoplay is paused</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ],
                    [
                        'id' => 'inherited',
                        'title' => 'Inherited Methods',
                        'content' => '
                            <p class="so-text-muted so-mb-4">Carousel inherits all base methods from the Element class.</p>
                            <div class="so-table-responsive">
                                <table class="so-table so-table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%">Method</th>
                                            <th style="width: 25%">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code>id()</code></td>
                                            <td><code>string $id</code></td>
                                            <td>Set element ID attribute</td>
                                        </tr>
                                        <tr>
                                            <td><code>addClass()</code></td>
                                            <td><code>string $class</code></td>
                                            <td>Add CSS class to element</td>
                                        </tr>
                                        <tr>
                                            <td><code>removeClass()</code></td>
                                            <td><code>string $class</code></td>
                                            <td>Remove CSS class from element</td>
                                        </tr>
                                        <tr>
                                            <td><code>attr()</code></td>
                                            <td><code>string $name</code><br><code>string $value</code></td>
                                            <td>Set custom HTML attribute</td>
                                        </tr>
                                        <tr>
                                            <td><code>data()</code></td>
                                            <td><code>string $key</code><br><code>string $value</code></td>
                                            <td>Set data attribute (automatically prefixed with <code>data-so-</code>)</td>
                                        </tr>
                                        <tr>
                                            <td><code>render()</code></td>
                                            <td>-</td>
                                            <td>Generate and return HTML string</td>
                                        </tr>
                                        <tr>
                                            <td><code>toArray()</code></td>
                                            <td>-</td>
                                            <td>Export configuration as array (PHP)</td>
                                        </tr>
                                        <tr>
                                            <td><code>toConfig()</code></td>
                                            <td>-</td>
                                            <td>Export configuration as object (JS)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        '
                    ]
                ]) ?>
            </div>
        </div>

        <!-- Validation -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Validation</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Carousel components do not have built-in validation as they are display elements rather than form inputs.</p>

                <?= callout('info', '<strong>Note:</strong> If you need to validate carousel-related data (e.g., minimum number of slides, required captions), implement custom validation logic in your application layer before rendering the carousel.') ?>

                <?= so_code_block('// Custom validation example (application level)
function validateCarouselData($slides) {
    if (empty($slides)) {
        throw new Exception("Carousel must have at least one slide");
    }

    foreach ($slides as $slide) {
        if (empty($slide[\'image\'])) {
            throw new Exception("Each slide must have an image");
        }
    }

    return true;
}

// Then create carousel
$slides = [...];
validateCarouselData($slides);

$carousel = UiEngine::carousel()
    ->slides($slides)
    ->render();', 'php') ?>
            </div>
        </div>

        <!-- Error Handling -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Error Handling</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">The Carousel component provides robust error handling for common scenarios.</p>

                <h5 class="so-mt-4 so-mb-3">Common Error Scenarios</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th>Scenario</th>
                                <th>Behavior</th>
                                <th>Prevention</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Empty slides array</td>
                                <td>Carousel renders empty container with no errors</td>
                                <td>Check <code>count($slides) > 0</code> before rendering</td>
                            </tr>
                            <tr>
                                <td>Invalid image URL</td>
                                <td>Browser displays broken image icon</td>
                                <td>Validate image URLs before adding slides</td>
                            </tr>
                            <tr>
                                <td>Single slide with controls</td>
                                <td>Controls automatically hidden (not useful for 1 slide)</td>
                                <td>No action needed - handled automatically</td>
                            </tr>
                            <tr>
                                <td>Missing SOCarousel JS class</td>
                                <td>Carousel displays but doesn\'t transition</td>
                                <td>Ensure ui-engine.js is loaded or include SOCarousel manually</td>
                            </tr>
                            <tr>
                                <td>Conflicting slide indices</td>
                                <td>SOCarousel normalizes indices automatically</td>
                                <td>No action needed - handled internally</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">JavaScript Error Handling</h5>
                <?= so_code_block('// Listen for slide transition errors
const carouselEl = document.getElementById(\'my-carousel\');

carouselEl.addEventListener(\'so:carousel:slide\', (e) => {
    // Prevent slide if validation fails
    if (!validateSlideTransition(e.detail.from, e.detail.to)) {
        e.preventDefault();
        console.error(\'Invalid slide transition\');
    }
});

// Handle missing carousel instance
const carousel = SOCarousel.getInstance(carouselEl);
if (!carousel) {
    console.error(\'Carousel not initialized\');
    // Fallback: initialize manually
    new SOCarousel(carouselEl);
}

// Safe navigation with error handling
try {
    carousel.goTo(slideIndex);
} catch (error) {
    console.error(\'Navigation failed:\', error);
    // Fallback to first slide
    carousel.goTo(0);
}', 'javascript') ?>

                <h5 class="so-mt-4 so-mb-3">PHP Error Prevention</h5>
                <?= so_code_block('// Safe carousel creation with validation
try {
    $carousel = UiEngine::carousel();

    // Validate slides exist
    if (!empty($slides)) {
        foreach ($slides as $slide) {
            // Sanitize and validate each slide
            $image = filter_var($slide[\'image\'] ?? \'\', FILTER_SANITIZE_URL);
            $title = htmlspecialchars($slide[\'title\'] ?? \'\', ENT_QUOTES);
            $description = htmlspecialchars($slide[\'description\'] ?? \'\', ENT_QUOTES);

            if (!empty($image)) {
                $carousel->addSlide($image, $title, $description);
            }
        }
    }

    echo $carousel->render();

} catch (Exception $e) {
    // Log error and show fallback
    error_log("Carousel error: " . $e->getMessage());
    echo \'<div class="so-alert so-alert-warning">Unable to load carousel</div>\';
}', 'php') ?>

                <?= callout('tip', '<strong>Best Practice:</strong> Always validate and sanitize user-provided data (images, captions) before passing to the Carousel component to prevent XSS attacks and broken layouts.') ?>
            </div>
        </div>

        <!-- UiEngine vs SOCarousel -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">UiEngine Carousel vs SOCarousel</h3>
            </div>
            <div class="so-card-body">
                <p class="so-text-muted so-mb-4">Understanding the difference between the UiEngine Carousel class and the SOCarousel runtime class.</p>

                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 30%">Aspect</th>
                                <th>UiEngine Carousel (PHP/JS)</th>
                                <th>SOCarousel (Runtime JS)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Purpose</strong></td>
                                <td>HTML generation and configuration</td>
                                <td>Runtime interactivity and behavior</td>
                            </tr>
                            <tr>
                                <td><strong>When Used</strong></td>
                                <td>During initial page render (server or client)</td>
                                <td>After DOM is ready, for user interactions</td>
                            </tr>
                            <tr>
                                <td><strong>Key Methods</strong></td>
                                <td><code>addSlide()</code>, <code>autoplay()</code>, <code>fade()</code>, <code>hero()</code>, <code>render()</code></td>
                                <td><code>next()</code>, <code>prev()</code>, <code>goTo()</code>, <code>play()</code>, <code>pause()</code></td>
                            </tr>
                            <tr>
                                <td><strong>Output</strong></td>
                                <td>HTML string with proper structure and data attributes</td>
                                <td>Live DOM manipulation and event handling</td>
                            </tr>
                            <tr>
                                <td><strong>Events</strong></td>
                                <td>N/A (no events, just rendering)</td>
                                <td>Emits <code>so:carousel:slide</code>, <code>so:carousel:slid</code>, <code>so:carousel:play</code>, <code>so:carousel:pause</code></td>
                            </tr>
                            <tr>
                                <td><strong>Initialization</strong></td>
                                <td>Instantiate with <code>UiEngine::carousel()</code> or <code>UiEngine.carousel()</code></td>
                                <td>Auto-initialized via <code>data-so-carousel</code> or manual <code>new SOCarousel(element)</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="so-mt-4 so-mb-3">Workflow Example</h5>
                <?= so_code_tabs('carousel-workflow', [
                    ['language' => 'php', 'code' => '// Step 1: Use UiEngine Carousel to generate HTML (server-side)
$carousel = UiEngine::carousel()
    ->id(\'product-carousel\')
    ->addSlide(\'image1.jpg\', \'Product 1\')
    ->addSlide(\'image2.jpg\', \'Product 2\')
    ->autoplay(true)
    ->interval(4000)
    ->render();

echo $carousel;
// Outputs: <div class="so-carousel" data-so-carousel data-so-autoplay="true" data-so-interval="4000" id="product-carousel">...</div>'],
                    ['language' => 'javascript', 'code' => '// Step 2: SOCarousel automatically initializes on DOMContentLoaded
// (because of data-so-carousel attribute)

// Step 3: Get instance for runtime control
const carousel = SOCarousel.getInstance(document.getElementById(\'product-carousel\'));

// Step 4: Control programmatically
carousel.pause();  // Pause autoplay
carousel.goTo(2);  // Jump to slide 3
carousel.play();   // Resume autoplay

// Step 5: Listen to events
carousel.element.addEventListener(\'so:carousel:slid\', (e) => {
    console.log(\'Now showing slide:\', e.detail.to + 1);
});']
                ]) ?>

                <?= callout('info', '<strong>Summary:</strong> Use <code>UiEngine::carousel()</code> to <em>create</em> the carousel HTML. Use <code>SOCarousel</code> to <em>control</em> it after rendering.') ?>
            </div>
        </div>

    </div>
</div>

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

        const gallery = element.closest('.so-carousel-gallery');
        this.thumbnails = gallery ? Array.from(gallery.querySelectorAll('.so-carousel-thumbnail')) : [];

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
        this.thumbnails.forEach((thumb, index) => thumb.addEventListener('click', () => this.goTo(index)));
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
        document.addEventListener('visibilitychange', () => {
            if (document.hidden && this.isPlaying && !this.isManuallyPaused) this._pauseAutoplay(false);
            else if (!document.hidden && this.isPlaying && !this.isPaused && !this.isManuallyPaused) this._resumeAutoplay();
        });
    }

    _handleKeydown(e) {
        switch (e.key) {
            case 'ArrowLeft': e.preventDefault(); this.prev(); break;
            case 'ArrowRight': e.preventDefault(); this.next(); break;
            case 'Home': e.preventDefault(); this.goTo(0); break;
            case 'End': e.preventDefault(); this.goTo(this.slides.length - 1); break;
            case ' ': e.preventDefault(); this.isPlaying ? this.pause() : this.play(); break;
        }
    }

    _handleTouchStart(e) { if (this.isSliding) return; this.touchStartX = e.touches[0].clientX; this.touchCurrentX = this.touchStartX; this.isDragging = true; this.element.classList.add('so-carousel-dragging'); }
    _handleTouchMove(e) { if (!this.isDragging) return; this.touchCurrentX = e.touches[0].clientX; if (Math.abs(this.touchCurrentX - this.touchStartX) > 10) e.preventDefault(); }
    _handleTouchEnd() { if (!this.isDragging) return; this.isDragging = false; this.element.classList.remove('so-carousel-dragging'); const diff = this.touchCurrentX - this.touchStartX; if (Math.abs(diff) > 50) diff > 0 ? this.prev() : this.next(); }
    _handleMouseDown(e) {
        if (e.button !== 0) return;
        this.touchStartX = e.clientX; this.touchCurrentX = e.clientX; this.isDragging = true; this.element.classList.add('so-carousel-dragging');
        const handleMouseMove = (e) => { this.touchCurrentX = e.clientX; };
        const handleMouseUp = () => { document.removeEventListener('mousemove', handleMouseMove); document.removeEventListener('mouseup', handleMouseUp); this.isDragging = false; this.element.classList.remove('so-carousel-dragging'); const diff = this.touchCurrentX - this.touchStartX; if (Math.abs(diff) > 50) diff > 0 ? this.prev() : this.next(); };
        document.addEventListener('mousemove', handleMouseMove); document.addEventListener('mouseup', handleMouseUp);
    }

    next() { if (this.isSliding) return this; let nextIndex = this.currentIndex + 1; if (nextIndex >= this.slides.length) nextIndex = this.options.loop ? 0 : this.slides.length - 1; if (nextIndex !== this.currentIndex) this.goTo(nextIndex); return this; }
    prev() { if (this.isSliding) return this; let prevIndex = this.currentIndex - 1; if (prevIndex < 0) prevIndex = this.options.loop ? this.slides.length - 1 : 0; if (prevIndex !== this.currentIndex) this.goTo(prevIndex); return this; }

    goTo(index) {
        if (this.isSliding || index === this.currentIndex) return this;
        if (index < 0 || index >= this.slides.length) return this;
        const prevIndex = this.currentIndex;
        const direction = index > prevIndex ? 'next' : 'prev';
        const slideEvent = new CustomEvent('so:carousel:slide', { detail: { from: prevIndex, to: index, direction }, bubbles: true, cancelable: true });
        if (!this.element.dispatchEvent(slideEvent)) return this;
        this.isSliding = true; this.element.classList.add('so-carousel-sliding');
        this.slides[prevIndex].classList.remove('so-active'); this.slides[index].classList.add('so-active'); this.currentIndex = index;
        this._updateIndicators(); this._resetProgress(); this._updateTransform();
        setTimeout(() => {
            this.isSliding = false; this.element.classList.remove('so-carousel-sliding');
            this.element.dispatchEvent(new CustomEvent('so:carousel:slid', { detail: { from: prevIndex, to: index, direction }, bubbles: true }));
            if (this.isPlaying && !this.isPaused) this._resetAutoplayTimer();
        }, 600);
        return this;
    }

    _updateTransform() {
        if (!this.inner) return;
        const isFade = this.element.classList.contains('so-carousel-fade');
        const isHero = this.element.classList.contains('so-carousel-hero');
        const isMulti = this.element.classList.contains('so-carousel-multi');
        if (isFade) return;
        const slide = this.slides[this.currentIndex]; if (!slide) return;
        if (isHero) { const slideStyle = getComputedStyle(slide); const slideMargin = parseFloat(slideStyle.marginLeft) || 0; const slideWidth = slide.offsetWidth; const slideFullWidth = slideWidth + (slideMargin * 2); this.inner.style.transform = `translateX(-${this.currentIndex * slideFullWidth}px)`; }
        else if (isMulti) { const slideOffset = slide.offsetLeft; const slideStyle = getComputedStyle(slide); const slideMargin = parseFloat(slideStyle.marginLeft) || 0; this.inner.style.transform = `translateX(-${slideOffset - slideMargin}px)`; }
        else { this.inner.style.transform = `translateX(-${this.currentIndex * 100}%)`; }
    }

    _updateIndicators() { this.indicators.forEach((ind, i) => ind.classList.toggle('so-active', i === this.currentIndex)); this.thumbnails.forEach((thumb, i) => thumb.classList.toggle('so-active', i === this.currentIndex)); }
    _resetProgress() { if (this.progressBar) { this.progressBar.style.animation = 'none'; this.progressBar.offsetHeight; this.progressBar.style.animation = ''; } }
    play() { if (this.slides.length <= 1) return this; this.isPlaying = true; this.isPaused = false; this.isManuallyPaused = false; this._resetAutoplayTimer(); this.element.classList.remove('so-paused'); this.element.dispatchEvent(new CustomEvent('so:carousel:play', { bubbles: true })); return this; }
    pause() { this.isManuallyPaused = true; this._pauseAutoplay(true); this.element.dispatchEvent(new CustomEvent('so:carousel:pause', { bubbles: true })); return this; }
    stop() { this.isPlaying = false; this.isPaused = false; this.isManuallyPaused = false; if (this.autoplayTimer) { clearInterval(this.autoplayTimer); this.autoplayTimer = null; } this.element.classList.remove('so-paused'); return this; }
    _pauseAutoplay(updateState = true) { if (updateState) this.isPaused = true; if (this.autoplayTimer) { clearInterval(this.autoplayTimer); this.autoplayTimer = null; } this.element.classList.add('so-paused'); }
    _resumeAutoplay() { this.isPaused = false; this.element.classList.remove('so-paused'); this._resetAutoplayTimer(); }
    _resetAutoplayTimer() { if (this.autoplayTimer) clearInterval(this.autoplayTimer); if (this.options.interval > 0 && this.isPlaying && !this.isPaused) this.autoplayTimer = setInterval(() => this.next(), this.options.interval); }
    getCurrentIndex() { return this.currentIndex; }
    getSlideCount() { return this.slides.length; }
    isPlaying() { return this.isPlaying; }
    destroy() { this.stop(); SOCarousel.instances.delete(this.element); }
}

document.addEventListener('DOMContentLoaded', function() {
    SOCarousel.initAll();
    window.apiCarousel = SOCarousel.getInstance(document.getElementById('api-carousel'));
    window.autoplayCarousel = SOCarousel.getInstance(document.getElementById('autoplay-carousel'));

    // Setup autoplay control buttons
    const playBtn = document.getElementById('autoplay-play-btn');
    const pauseBtn = document.getElementById('autoplay-pause-btn');
    if (playBtn && window.autoplayCarousel) {
        playBtn.addEventListener('click', () => window.autoplayCarousel.play());
    }
    if (pauseBtn && window.autoplayCarousel) {
        pauseBtn.addEventListener('click', () => window.autoplayCarousel.pause());
    }

    const eventsCarousel = document.getElementById('events-carousel');
    const eventLog = document.getElementById('carousel-event-log');
    if (eventsCarousel && eventLog) {
        eventsCarousel.addEventListener('so:carousel:slide', (e) => { eventLog.innerHTML = `<span class="material-icons">sync</span><span><strong>slide:</strong> from=${e.detail.from + 1} to=${e.detail.to + 1} direction=${e.detail.direction}</span>`; });
        eventsCarousel.addEventListener('so:carousel:slid', (e) => { eventLog.innerHTML = `<span class="material-icons">check_circle</span><span><strong>slid:</strong> now at slide ${e.detail.to + 1}</span>`; });
    }
});

function copyCode(button) {
    const codeBlock = button.closest('.so-code-block');
    const activePane = codeBlock.querySelector('.so-code-pane.so-active') || codeBlock;
    const code = activePane.querySelector('.so-code-content code').textContent;
    navigator.clipboard.writeText(code).then(() => {
        button.innerHTML = '<span class="material-icons">check</span>';
        setTimeout(() => { button.innerHTML = '<span class="material-icons">content_copy</span>'; }, 2000);
    });
}
</script>

</main>

<?php require_once '../includes/footer.php'; ?>
