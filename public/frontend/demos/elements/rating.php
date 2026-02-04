<?php
/**
 * SixOrbit UI Demo - Rating
 */
$pageTitle = 'Rating';
$pageDescription = 'Star rating components for user feedback and reviews.';

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
            <h1 class="so-page-title"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="so-page-subtitle"><?= htmlspecialchars($pageDescription) ?></p>
        </div>
    </div>

    <!-- Page Body -->
    <div class="so-page-body">

<!-- Basic Rating -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Basic Rating</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Interactive star rating component. Click to select a rating.</p>

        <div class="so-rating so-rating-interactive">
            <input type="radio" name="rating1" value="5" id="rating1-5" class="so-rating-input">
            <label for="rating1-5" class="so-rating-label"><span class="material-icons">star</span></label>
            <input type="radio" name="rating1" value="4" id="rating1-4" class="so-rating-input">
            <label for="rating1-4" class="so-rating-label"><span class="material-icons">star</span></label>
            <input type="radio" name="rating1" value="3" id="rating1-3" class="so-rating-input" checked>
            <label for="rating1-3" class="so-rating-label"><span class="material-icons">star</span></label>
            <input type="radio" name="rating1" value="2" id="rating1-2" class="so-rating-input">
            <label for="rating1-2" class="so-rating-label"><span class="material-icons">star</span></label>
            <input type="radio" name="rating1" value="1" id="rating1-1" class="so-rating-input">
            <label for="rating1-1" class="so-rating-label"><span class="material-icons">star</span></label>
        </div>
        <?= so_code_block('<!-- Interactive rating with CSS-only hover effect -->
<div class="so-rating so-rating-interactive">
    <input type="radio" name="rating" value="5" id="rating-5" class="so-rating-input">
    <label for="rating-5" class="so-rating-label"><span class="material-icons">star</span></label>
    <input type="radio" name="rating" value="4" id="rating-4" class="so-rating-input">
    <label for="rating-4" class="so-rating-label"><span class="material-icons">star</span></label>
    <input type="radio" name="rating" value="3" id="rating-3" class="so-rating-input" checked>
    <label for="rating-3" class="so-rating-label"><span class="material-icons">star</span></label>
    <input type="radio" name="rating" value="2" id="rating-2" class="so-rating-input">
    <label for="rating-2" class="so-rating-label"><span class="material-icons">star</span></label>
    <input type="radio" name="rating" value="1" id="rating-1" class="so-rating-input">
    <label for="rating-1" class="so-rating-label"><span class="material-icons">star</span></label>
</div>

<!-- Note: Inputs are in reverse order (5-1) for CSS sibling selector hover effect -->', 'html') ?>
    </div>
</div>

<!-- Read-only Rating -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Read-only Rating</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Display-only ratings for showing reviews.</p>

        <div class="so-d-flex so-flex-column so-gap-3">
            <div class="so-d-flex so-align-items-center so-gap-2">
                <div class="so-rating so-rating-readonly" data-rating="5">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                </div>
                <span class="so-text-muted">5.0 - Excellent</span>
            </div>
            <div class="so-d-flex so-align-items-center so-gap-2">
                <div class="so-rating so-rating-readonly" data-rating="4">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
                <span class="so-text-muted">4.0 - Very Good</span>
            </div>
            <div class="so-d-flex so-align-items-center so-gap-2">
                <div class="so-rating so-rating-readonly" data-rating="3">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
                <span class="so-text-muted">3.0 - Good</span>
            </div>
        </div>
        <?= so_code_block('<!-- Read-only rating display -->
<div class="so-rating so-rating-readonly">
    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
</div>

<!-- Use star_border for empty stars, star for filled -->', 'html') ?>
    </div>
</div>

<!-- Half Star Rating -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Half Star Rating</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Ratings with half-star precision.</p>

        <div class="so-d-flex so-flex-column so-gap-3">
            <div class="so-d-flex so-align-items-center so-gap-2">
                <div class="so-rating so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-half"><span class="material-icons">star_half</span></span>
                </div>
                <span class="so-text-muted">4.5</span>
            </div>
            <div class="so-d-flex so-align-items-center so-gap-2">
                <div class="so-rating so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-half"><span class="material-icons">star_half</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
                <span class="so-text-muted">3.5</span>
            </div>
        </div>
        <?= so_code_block('<!-- Half star rating using star_half icon -->
<div class="so-rating so-rating-readonly">
    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
    <span class="so-rating-star so-rating-half"><span class="material-icons">star_half</span></span>
    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
</div>', 'html') ?>
    </div>
</div>

<!-- Size Variants -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Size Variants</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Different sizes for various contexts.</p>

        <div class="so-d-flex so-flex-column so-gap-4">
            <div>
                <label class="so-form-label">Small</label>
                <div class="so-rating so-rating-sm so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
            </div>
            <div>
                <label class="so-form-label">Default</label>
                <div class="so-rating so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
            </div>
            <div>
                <label class="so-form-label">Large</label>
                <div class="so-rating so-rating-lg so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
            </div>
        </div>
        <?= so_code_block('<!-- Small rating -->
<div class="so-rating so-rating-sm so-rating-readonly">...</div>

<!-- Default rating -->
<div class="so-rating so-rating-readonly">...</div>

<!-- Large rating -->
<div class="so-rating so-rating-lg so-rating-readonly">...</div>', 'html') ?>
    </div>
</div>

<!-- Color Variants -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Color Variants</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Ratings in different colors.</p>

        <div class="so-d-flex so-flex-column so-gap-3">
            <div class="so-d-flex so-align-items-center so-gap-3">
                <span class="so-text-muted" style="width: 80px;">Default</span>
                <div class="so-rating so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
            </div>
            <div class="so-d-flex so-align-items-center so-gap-3">
                <span class="so-text-muted" style="width: 80px;">Primary</span>
                <div class="so-rating so-rating-primary so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
            </div>
            <div class="so-d-flex so-align-items-center so-gap-3">
                <span class="so-text-muted" style="width: 80px;">Success</span>
                <div class="so-rating so-rating-success so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
            </div>
            <div class="so-d-flex so-align-items-center so-gap-3">
                <span class="so-text-muted" style="width: 80px;">Danger</span>
                <div class="so-rating so-rating-danger so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
            </div>
        </div>
        <?= so_code_block('<!-- Color variants -->
<div class="so-rating so-rating-readonly">...</div>
<div class="so-rating so-rating-primary so-rating-readonly">...</div>
<div class="so-rating so-rating-success so-rating-readonly">...</div>
<div class="so-rating so-rating-danger so-rating-readonly">...</div>', 'html') ?>
    </div>
</div>

<!-- Icon Variants -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Icon Variants</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Use different icons for ratings.</p>

        <div class="so-d-flex so-flex-column so-gap-4">
            <div>
                <label class="so-form-label">Hearts</label>
                <div class="so-rating so-rating-hearts so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">favorite</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">favorite</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">favorite</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">favorite</span></span>
                    <span class="so-rating-star"><span class="material-icons">favorite_border</span></span>
                </div>
            </div>
            <div>
                <label class="so-form-label">Thumbs</label>
                <div class="so-rating so-rating-thumbs so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">thumb_up</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">thumb_up</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">thumb_up</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">thumb_up</span></span>
                    <span class="so-rating-star"><span class="material-icons">thumb_up_off_alt</span></span>
                </div>
            </div>
            <div>
                <label class="so-form-label">Emoji</label>
                <div class="so-rating so-rating-emoji so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">sentiment_very_satisfied</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">sentiment_satisfied</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">sentiment_neutral</span></span>
                    <span class="so-rating-star"><span class="material-icons">sentiment_dissatisfied</span></span>
                    <span class="so-rating-star"><span class="material-icons">sentiment_very_dissatisfied</span></span>
                </div>
            </div>
        </div>
        <?= so_code_block('<!-- Hearts -->
<div class="so-rating so-rating-hearts so-rating-readonly">
    <span class="so-rating-star so-rating-filled"><span class="material-icons">favorite</span></span>
    <span class="so-rating-star"><span class="material-icons">favorite_border</span></span>
</div>

<!-- Thumbs -->
<div class="so-rating so-rating-thumbs so-rating-readonly">
    <span class="so-rating-star so-rating-filled"><span class="material-icons">thumb_up</span></span>
    <span class="so-rating-star"><span class="material-icons">thumb_up_off_alt</span></span>
</div>

<!-- Emoji -->
<div class="so-rating so-rating-emoji so-rating-readonly">
    <span class="so-rating-star so-rating-filled"><span class="material-icons">sentiment_very_satisfied</span></span>
    <span class="so-rating-star"><span class="material-icons">sentiment_dissatisfied</span></span>
</div>', 'html') ?>
    </div>
</div>

<!-- Rating with Value Display -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Rating with Value Display</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Show numeric value alongside stars.</p>

        <div class="so-d-flex so-flex-column so-gap-4">
            <div class="so-rating-display">
                <div class="so-rating-value">4.8</div>
                <div class="so-rating so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                </div>
                <span class="so-text-muted">(1,234 reviews)</span>
            </div>

            <div class="so-rating-display">
                <div class="so-rating-value">3.5</div>
                <div class="so-rating so-rating-readonly">
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                    <span class="so-rating-star so-rating-half"><span class="material-icons">star_half</span></span>
                    <span class="so-rating-star"><span class="material-icons">star_border</span></span>
                </div>
                <span class="so-text-muted">(567 reviews)</span>
            </div>
        </div>
        <?= so_code_block('<div class="so-rating-display">
    <div class="so-rating-value">4.8</div>
    <div class="so-rating so-rating-readonly">
        <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
        <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
        <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
        <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
        <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
    </div>
    <span class="so-text-muted">(1,234 reviews)</span>
</div>', 'html') ?>
    </div>
</div>

<!-- Rating Summary -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Rating Summary</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Complete rating breakdown with bars.</p>

        <div class="so-rating-summary">
            <div class="so-rating-summary-header">
                <div class="so-rating-summary-score">4.5</div>
                <div class="so-rating-summary-info">
                    <div class="so-rating so-rating-lg so-rating-readonly">
                        <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                        <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                        <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                        <span class="so-rating-star so-rating-filled"><span class="material-icons">star</span></span>
                        <span class="so-rating-star so-rating-half"><span class="material-icons">star_half</span></span>
                    </div>
                    <span class="so-text-muted">Based on 2,456 reviews</span>
                </div>
            </div>
            <div class="so-rating-bars">
                <div class="so-rating-bar-item">
                    <span class="so-rating-bar-label">5</span>
                    <div class="so-progress so-progress-sm">
                        <div class="so-progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="so-rating-bar-count">1,719</span>
                </div>
                <div class="so-rating-bar-item">
                    <span class="so-rating-bar-label">4</span>
                    <div class="so-progress so-progress-sm">
                        <div class="so-progress-bar" style="width: 20%"></div>
                    </div>
                    <span class="so-rating-bar-count">491</span>
                </div>
                <div class="so-rating-bar-item">
                    <span class="so-rating-bar-label">3</span>
                    <div class="so-progress so-progress-sm">
                        <div class="so-progress-bar" style="width: 6%"></div>
                    </div>
                    <span class="so-rating-bar-count">147</span>
                </div>
                <div class="so-rating-bar-item">
                    <span class="so-rating-bar-label">2</span>
                    <div class="so-progress so-progress-sm">
                        <div class="so-progress-bar" style="width: 3%"></div>
                    </div>
                    <span class="so-rating-bar-count">74</span>
                </div>
                <div class="so-rating-bar-item">
                    <span class="so-rating-bar-label">1</span>
                    <div class="so-progress so-progress-sm">
                        <div class="so-progress-bar" style="width: 1%"></div>
                    </div>
                    <span class="so-rating-bar-count">25</span>
                </div>
            </div>
        </div>
        <?= so_code_block('<div class="so-rating-summary">
    <div class="so-rating-summary-header">
        <div class="so-rating-summary-score">4.5</div>
        <div class="so-rating-summary-info">
            <div class="so-rating so-rating-lg so-rating-readonly">...</div>
            <span class="so-text-muted">Based on 2,456 reviews</span>
        </div>
    </div>
    <div class="so-rating-bars">
        <div class="so-rating-bar-item">
            <span class="so-rating-bar-label">5</span>
            <div class="so-progress so-progress-sm">
                <div class="so-progress-bar" style="width: 70%"></div>
            </div>
            <span class="so-rating-bar-count">1,719</span>
        </div>
        <!-- More rating bars... -->
    </div>
</div>', 'html') ?>
    </div>
</div>

<!-- Interactive Rating Form -->
<div class="so-card so-mb-4">
    <div class="so-card-header">
        <h3 class="so-card-title">Rating Form</h3>
    </div>
    <div class="so-card-body">
        <p class="so-text-muted so-mb-4">Complete rating form with interactive stars.</p>

        <form class="so-rating-form">
            <div class="so-form-group">
                <label class="so-form-label">Your Rating</label>
                <div class="so-rating" data-rating="0">
                    <input type="radio" name="userRating" value="1" id="userRating-1" class="so-rating-input">
                    <label for="userRating-1" class="so-rating-label"><span class="material-icons">star</span></label>
                    <input type="radio" name="userRating" value="2" id="userRating-2" class="so-rating-input">
                    <label for="userRating-2" class="so-rating-label"><span class="material-icons">star</span></label>
                    <input type="radio" name="userRating" value="3" id="userRating-3" class="so-rating-input">
                    <label for="userRating-3" class="so-rating-label"><span class="material-icons">star</span></label>
                    <input type="radio" name="userRating" value="4" id="userRating-4" class="so-rating-input">
                    <label for="userRating-4" class="so-rating-label"><span class="material-icons">star</span></label>
                    <input type="radio" name="userRating" value="5" id="userRating-5" class="so-rating-input">
                    <label for="userRating-5" class="so-rating-label"><span class="material-icons">star</span></label>
                </div>
            </div>
            <div class="so-form-group">
                <label class="so-form-label">Review Title</label>
                <input type="text" class="so-form-control" placeholder="Summarize your experience">
            </div>
            <div class="so-form-group">
                <label class="so-form-label">Your Review</label>
                <textarea class="so-form-control" rows="4" placeholder="Tell us what you liked or didn't like"></textarea>
            </div>
            <button type="submit" class="so-btn so-btn-primary">Submit Review</button>
        </form>
        <?= so_code_block('<form class="so-rating-form">
    <div class="so-form-group">
        <label class="so-form-label">Your Rating</label>
        <div class="so-rating">
            <input type="radio" name="rating" value="1" id="rating-1" class="so-rating-input">
            <label for="rating-1" class="so-rating-label"><span class="material-icons">star</span></label>
            <!-- More rating inputs... -->
        </div>
    </div>
    <div class="so-form-group">
        <label class="so-form-label">Review Title</label>
        <input type="text" class="so-form-control" placeholder="Summarize your experience">
    </div>
    <div class="so-form-group">
        <label class="so-form-label">Your Review</label>
        <textarea class="so-form-control" rows="4"></textarea>
    </div>
    <button type="submit" class="so-btn so-btn-primary">Submit Review</button>
</form>', 'html') ?>
    </div>
</div>

    </div>
</main>

<script>
function copyCode(button) {
    const codeBlock = button.closest('.so-code-block');
    const code = codeBlock.querySelector('.so-code-content code').textContent;
    navigator.clipboard.writeText(code).then(() => {
        button.innerHTML = '<span class="material-icons">check</span>';
        setTimeout(() => {
            button.innerHTML = '<span class="material-icons">content_copy</span>';
        }, 2000);
    });
}
</script>

<?php require_once '../includes/footer.php'; ?>
