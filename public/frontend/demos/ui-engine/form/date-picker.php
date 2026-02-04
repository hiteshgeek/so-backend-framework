<?php
/**
 * SixOrbit UI Engine - Date Picker Element Demo
 */

$pageTitle = 'Date Picker - UI Engine';
$pageDescription = 'Date picker with range selection and formatting options';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Date Picker</h1>
            <p class="so-page-subtitle">Date picker element with single date, date range, and various formatting options.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Date Picker -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Date Picker</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label" for="demo-date">Select Date</label>
                    <input type="date" class="so-form-control" id="demo-date" name="date">
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-date', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$datePicker = UiEngine::datePicker('birthdate')
    ->label('Select Date');

echo \$datePicker->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const datePicker = UiEngine.datePicker('birthdate')
    .label('Select Date');

document.getElementById('container').innerHTML = datePicker.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label" for="birthdate">Select Date</label>
    <input type="date" class="so-form-control" id="birthdate" name="birthdate">
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Min/Max Dates -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Min/Max Dates</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label" for="demo-booking">Booking Date</label>
                    <input type="date" class="so-form-control" id="demo-booking" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+30 days')) ?>">
                    <div class="so-form-hint">Select a date within the next 30 days</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('date-minmax', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$datePicker = UiEngine::datePicker('booking_date')
    ->label('Booking Date')
    ->minDate(date('Y-m-d'))                    // Today
    ->maxDate(date('Y-m-d', strtotime('+30 days'))) // 30 days from now
    ->helpText('Select a date within the next 30 days');

echo \$datePicker->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const today = new Date().toISOString().split('T')[0];
const max = new Date(Date.now() + 30*24*60*60*1000).toISOString().split('T')[0];

const datePicker = UiEngine.datePicker('booking_date')
    .label('Booking Date')
    .minDate(today)
    .maxDate(max)
    .helpText('Select a date within the next 30 days');

document.getElementById('container').innerHTML = datePicker.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Date Range -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Date Range</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                    <div class="so-form-group">
                        <label class="so-form-label" for="demo-start">Start Date</label>
                        <input type="date" class="so-form-control" id="demo-start" name="start_date">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label" for="demo-end">End Date</label>
                        <input type="date" class="so-form-control" id="demo-end" name="end_date">
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('date-range', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Option 1: Two separate date pickers
\$startDate = UiEngine::datePicker('start_date')
    ->label('Start Date');

\$endDate = UiEngine::datePicker('end_date')
    ->label('End Date');

// Option 2: Date range picker
\$dateRange = UiEngine::dateRange('dates')
    ->label('Select Dates')
    ->startName('start_date')
    ->endName('end_date');

echo \$dateRange->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Option 1: Two separate date pickers
const startDate = UiEngine.datePicker('start_date')
    .label('Start Date');

const endDate = UiEngine.datePicker('end_date')
    .label('End Date');

// Option 2: Date range picker
const dateRange = UiEngine.dateRange('dates')
    .label('Select Dates')
    .startName('start_date')
    .endName('end_date')
    .onChange((start, end) => {
        console.log('Range:', start, 'to', end);
    });

document.getElementById('container').innerHTML = dateRange.toHtml();"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Date Formats -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Date Formats</h3>
            </div>
            <div class="so-card-body">
                <!-- Code Tabs -->
                <?= so_code_tabs('date-formats', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// ISO format (default): 2026-02-03
UiEngine::datePicker('iso_date')
    ->format('Y-m-d');

// US format: 02/03/2026
UiEngine::datePicker('us_date')
    ->format('m/d/Y');

// European format: 03/02/2026
UiEngine::datePicker('eu_date')
    ->format('d/m/Y');

// Disable weekends
UiEngine::datePicker('weekday_date')
    ->disableWeekends()
    ->label('Business Days Only');"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// ISO format (default): 2026-02-03
UiEngine.datePicker('iso_date')
    .format('Y-m-d');

// US format: 02/03/2026
UiEngine.datePicker('us_date')
    .format('m/d/Y');

// European format: 03/02/2026
UiEngine.datePicker('eu_date')
    .format('d/m/Y');

// Disable weekends
UiEngine.datePicker('weekday_date')
    .disableWeekends()
    .label('Business Days Only');"
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Default Value -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Default Value</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label" for="demo-default">Event Date</label>
                    <input type="date" class="so-form-control" id="demo-default" value="<?= date('Y-m-d') ?>">
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('date-default', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Today's date
\$datePicker = UiEngine::datePicker('event_date')
    ->label('Event Date')
    ->value(date('Y-m-d'));

// Specific date
\$datePicker = UiEngine::datePicker('deadline')
    ->label('Deadline')
    ->value('2026-12-31');

// From database
\$datePicker = UiEngine::datePicker('created_at')
    ->label('Created Date')
    ->value(\$record->created_at->format('Y-m-d'));"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Today's date
const datePicker = UiEngine.datePicker('event_date')
    .label('Event Date')
    .value(new Date().toISOString().split('T')[0]);

// Specific date
const deadline = UiEngine.datePicker('deadline')
    .label('Deadline')
    .value('2026-12-31');

// From data
const created = UiEngine.datePicker('created_at')
    .label('Created Date')
    .value(record.created_at);"
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
                <!-- API Tabs -->
                <div class="so-tabs" role="tablist" data-so-tabs>
                    <button class="so-tab so-active" role="tab" data-so-target="#api-php">PHP Class</button>
                    <button class="so-tab" role="tab" data-so-target="#api-js">JS UiEngine</button>
                </div>

                <div class="so-tab-content">
                    <!-- PHP Class Reference -->
                    <div class="so-tab-pane so-fade so-show so-active" id="api-php" role="tabpanel">
                        <h5 class="so-mt-3">Core\\UiEngine\\Elements\\Form\\DatePicker</h5>
                        <p class="so-text-muted">Extends FormElement</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine::datePicker(string $name)</code></td>
                                        <td>Create date picker with name</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Date Picker Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>format(string $format)</code></td>
                                        <td>Set date format (e.g., 'Y-m-d', 'm/d/Y')</td>
                                    </tr>
                                    <tr>
                                        <td><code>minDate(string $date)</code></td>
                                        <td>Set minimum selectable date</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxDate(string $date)</code></td>
                                        <td>Set maximum selectable date</td>
                                    </tr>
                                    <tr>
                                        <td><code>dateRange(string $min, string $max)</code></td>
                                        <td>Set both min and max dates at once</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabledDates(array $dates)</code></td>
                                        <td>Disable specific dates</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabledDays(array $days)</code></td>
                                        <td>Disable days of week (0=Sun, 6=Sat)</td>
                                    </tr>
                                    <tr>
                                        <td><code>disableWeekends()</code></td>
                                        <td>Disable Saturday and Sunday</td>
                                    </tr>
                                    <tr>
                                        <td><code>range(bool $val = true)</code></td>
                                        <td>Enable date range selection mode</td>
                                    </tr>
                                    <tr>
                                        <td><code>weekNumbers(bool $show = true)</code></td>
                                        <td>Show week numbers in calendar</td>
                                    </tr>
                                    <tr>
                                        <td><code>clearable(bool $val = true)</code></td>
                                        <td>Show clear button</td>
                                    </tr>
                                    <tr>
                                        <td><code>todayButton(bool $show = true)</code></td>
                                        <td>Show "Today" button</td>
                                    </tr>
                                    <tr>
                                        <td><code>firstDayOfWeek(int $day)</code></td>
                                        <td>Set first day of week (0=Sun, 1=Mon)</td>
                                    </tr>
                                    <tr>
                                        <td><code>weekStartsSunday()</code></td>
                                        <td>Start week on Sunday</td>
                                    </tr>
                                    <tr>
                                        <td><code>weekStartsMonday()</code></td>
                                        <td>Start week on Monday (default)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Inherited Methods (FormElement)</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>name(string $name)</code></td>
                                        <td>Set input name</td>
                                    </tr>
                                    <tr>
                                        <td><code>value(mixed $value)</code></td>
                                        <td>Set date value</td>
                                    </tr>
                                    <tr>
                                        <td><code>label(string $label)</code></td>
                                        <td>Set form label</td>
                                    </tr>
                                    <tr>
                                        <td><code>placeholder(string $text)</code></td>
                                        <td>Set placeholder text</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled(bool $val = true)</code></td>
                                        <td>Disable the input</td>
                                    </tr>
                                    <tr>
                                        <td><code>readonly(bool $val = true)</code></td>
                                        <td>Make input read-only</td>
                                    </tr>
                                    <tr>
                                        <td><code>required(bool $val = true)</code></td>
                                        <td>Mark as required</td>
                                    </tr>
                                    <tr>
                                        <td><code>helpText(string $text)</code></td>
                                        <td>Add help text below input</td>
                                    </tr>
                                    <tr>
                                        <td><code>error(string $message)</code></td>
                                        <td>Set validation error message</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JS UiEngine Reference -->
                    <div class="so-tab-pane so-fade" id="api-js" role="tabpanel">
                        <h5 class="so-mt-3">UiEngine.datePicker()</h5>
                        <p class="so-text-muted">Extends FormElement</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine.datePicker(name)</code></td>
                                        <td>Create date picker with name</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Date Picker Methods</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>format(fmt)</code></td>
                                        <td>Set date format</td>
                                    </tr>
                                    <tr>
                                        <td><code>minDate(date)</code></td>
                                        <td>Set minimum selectable date</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxDate(date)</code></td>
                                        <td>Set maximum selectable date</td>
                                    </tr>
                                    <tr>
                                        <td><code>dateRange(min, max)</code></td>
                                        <td>Set both min and max dates</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabledDates(dates)</code></td>
                                        <td>Disable specific dates</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabledDays(days)</code></td>
                                        <td>Disable days of week</td>
                                    </tr>
                                    <tr>
                                        <td><code>disableWeekends()</code></td>
                                        <td>Disable Saturday and Sunday</td>
                                    </tr>
                                    <tr>
                                        <td><code>range(val = true)</code></td>
                                        <td>Enable date range selection</td>
                                    </tr>
                                    <tr>
                                        <td><code>weekNumbers(val = true)</code></td>
                                        <td>Show week numbers</td>
                                    </tr>
                                    <tr>
                                        <td><code>clearable(val = true)</code></td>
                                        <td>Show clear button</td>
                                    </tr>
                                    <tr>
                                        <td><code>todayButton(val = true)</code></td>
                                        <td>Show "Today" button</td>
                                    </tr>
                                    <tr>
                                        <td><code>firstDayOfWeek(day)</code></td>
                                        <td>Set first day of week</td>
                                    </tr>
                                    <tr>
                                        <td><code>weekStartsSunday()</code></td>
                                        <td>Start week on Sunday</td>
                                    </tr>
                                    <tr>
                                        <td><code>weekStartsMonday()</code></td>
                                        <td>Start week on Monday</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Inherited Methods (FormElement)</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>name(name)</code></td>
                                        <td>Set input name</td>
                                    </tr>
                                    <tr>
                                        <td><code>value(value)</code></td>
                                        <td>Set date value</td>
                                    </tr>
                                    <tr>
                                        <td><code>label(label)</code></td>
                                        <td>Set form label</td>
                                    </tr>
                                    <tr>
                                        <td><code>placeholder(text)</code></td>
                                        <td>Set placeholder text</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled(val = true)</code></td>
                                        <td>Disable the input</td>
                                    </tr>
                                    <tr>
                                        <td><code>readonly(val = true)</code></td>
                                        <td>Make input read-only</td>
                                    </tr>
                                    <tr>
                                        <td><code>required(val = true)</code></td>
                                        <td>Mark as required</td>
                                    </tr>
                                    <tr>
                                        <td><code>helpText(text)</code></td>
                                        <td>Add help text below input</td>
                                    </tr>
                                    <tr>
                                        <td><code>error(message)</code></td>
                                        <td>Set validation error message</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Element Methods (Base)</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Method</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>id(id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>addClass(className)</code></td>
                                        <td>Add CSS class</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr(name, value)</code></td>
                                        <td>Set attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>data(key, value)</code></td>
                                        <td>Set data attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>on(event, handler)</code></td>
                                        <td>Attach event handler</td>
                                    </tr>
                                    <tr>
                                        <td><code>toHtml()</code></td>
                                        <td>Get HTML string</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>Render to DOM element</td>
                                    </tr>
                                    <tr>
                                        <td><code>toConfig()</code></td>
                                        <td>Export configuration object</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
