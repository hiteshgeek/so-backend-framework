<?php
/**
 * SixOrbit UI Engine - Time Picker Element Demo
 */

$pageTitle = 'Time Picker - UI Engine';
$pageDescription = 'Time picker with 12/24 hour format and step options';

require_once '../../includes/config.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';
require_once '../../includes/navbar.php';
?>

<main class="so-main-content">
    <!-- Page Header -->
    <div class="so-page-header">
        <div class="so-page-header-left">
            <h1 class="so-page-title">Time Picker</h1>
            <p class="so-page-subtitle">Time picker element with 12/24 hour format support, minute steps, and time range selection.</p>
        </div>
    </div>

    <div class="so-page-body">
        <!-- Basic Time Picker -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Basic Time Picker</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label" for="demo-time">Select Time</label>
                    <input type="time" class="so-form-control" id="demo-time" name="time">
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('basic-time', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "<?php
use Core\UiEngine\UiEngine;

\$timePicker = UiEngine::timePicker('appointment_time')
    ->label('Select Time');

echo \$timePicker->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const timePicker = UiEngine.timePicker('appointment_time')
    .label('Select Time');

document.getElementById('container').innerHTML = timePicker.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label" for="appointment_time">Select Time</label>
    <input type="time" class="so-form-control" id="appointment_time" name="appointment_time">
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Min/Max Time -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Min/Max Time</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-form-group">
                    <label class="so-form-label" for="demo-business">Business Hours</label>
                    <input type="time" class="so-form-control" id="demo-business" min="09:00" max="17:00">
                    <div class="so-form-hint">Select a time between 9:00 AM and 5:00 PM</div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('time-minmax', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "\$timePicker = UiEngine::timePicker('meeting_time')
    ->label('Business Hours')
    ->min('09:00')
    ->max('17:00')
    ->help('Select a time between 9:00 AM and 5:00 PM');

echo \$timePicker->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "const timePicker = UiEngine.timePicker('meeting_time')
    .label('Business Hours')
    .min('09:00')
    .max('17:00')
    .help('Select a time between 9:00 AM and 5:00 PM');

document.getElementById('container').innerHTML = timePicker.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-form-group">
    <label class="so-form-label" for="meeting_time">Business Hours</label>
    <input type="time" class="so-form-control" id="meeting_time" name="meeting_time" min="09:00" max="17:00">
    <div class="so-form-hint">Select a time between 9:00 AM and 5:00 PM</div>
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- With Step -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">With Step Intervals</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1">
                    <div class="so-form-group">
                        <label class="so-form-label">15 minute steps</label>
                        <input type="time" class="so-form-control" step="900">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">30 minute steps</label>
                        <input type="time" class="so-form-control" step="1800">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">1 hour steps</label>
                        <input type="time" class="so-form-control" step="3600">
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('time-step', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// 15 minute intervals
UiEngine::timePicker('slot_15')
    ->label('15 minute steps')
    ->step(15); // minutes

// 30 minute intervals
UiEngine::timePicker('slot_30')
    ->label('30 minute steps')
    ->step(30);

// 1 hour intervals
UiEngine::timePicker('slot_60')
    ->label('1 hour steps')
    ->step(60);"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// 15 minute intervals
UiEngine.timePicker('slot_15')
    .label('15 minute steps')
    .step(15); // minutes

// 30 minute intervals
UiEngine.timePicker('slot_30')
    .label('30 minute steps')
    .step(30);

// 1 hour intervals
UiEngine.timePicker('slot_60')
    .label('1 hour steps')
    .step(60);"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- 15 minute steps (step in seconds: 15 * 60 = 900) -->
<div class="so-form-group">
    <label class="so-form-label">15 minute steps</label>
    <input type="time" class="so-form-control" id="slot_15" name="slot_15" step="900">
</div>

<!-- 30 minute steps (step in seconds: 30 * 60 = 1800) -->
<div class="so-form-group">
    <label class="so-form-label">30 minute steps</label>
    <input type="time" class="so-form-control" id="slot_30" name="slot_30" step="1800">
</div>

<!-- 1 hour steps (step in seconds: 60 * 60 = 3600) -->
<div class="so-form-group">
    <label class="so-form-label">1 hour steps</label>
    <input type="time" class="so-form-control" id="slot_60" name="slot_60" step="3600">
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Time Formats -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Time Formats</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-3 so-grid-cols-sm-1">
                    <div class="so-form-group">
                        <label class="so-form-label">24-hour format</label>
                        <input type="time" class="so-form-control" value="14:30">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">With seconds</label>
                        <input type="time" class="so-form-control" step="1" value="14:30:00">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label">Default value</label>
                        <input type="time" class="so-form-control" value="09:00">
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('time-formats', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// 24-hour format (default)
UiEngine::timePicker('time_24')
    ->label('24-hour format')
    ->format('H:i'); // 14:30

// 12-hour format with AM/PM
UiEngine::timePicker('time_12')
    ->label('12-hour format')
    ->format('h:i A')   // For submission: 02:30 PM
    ->use12Hour();      // Enable 12-hour picker

// With seconds
UiEngine::timePicker('time_seconds')
    ->label('With seconds')
    ->format('H:i:s')
    ->showSeconds();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// 24-hour format (default)
UiEngine.timePicker('time_24')
    .label('24-hour format')
    .format('H:i'); // 14:30

// 12-hour format with AM/PM
UiEngine.timePicker('time_12')
    .label('12-hour format')
    .format('h:i A')
    .use12Hour();

// With seconds
UiEngine.timePicker('time_seconds')
    .label('With seconds')
    .format('H:i:s')
    .showSeconds();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<!-- 24-hour format -->
<div class="so-form-group">
    <label class="so-form-label">24-hour format</label>
    <input type="time" class="so-form-control" id="time_24" name="time_24" value="14:30">
</div>

<!-- With seconds (step="1" enables seconds) -->
<div class="so-form-group">
    <label class="so-form-label">With seconds</label>
    <input type="time" class="so-form-control" id="time_seconds" name="time_seconds" step="1" value="14:30:00">
</div>

<!-- With default value -->
<div class="so-form-group">
    <label class="so-form-label">Default value</label>
    <input type="time" class="so-form-control" id="time_default" name="time_default" value="09:00">
</div>'
                    ],
                ]) ?>
            </div>
        </div>

        <!-- Time Range -->
        <div class="so-card so-mb-4">
            <div class="so-card-header">
                <h3 class="so-card-title">Time Range</h3>
            </div>
            <div class="so-card-body">
                <!-- Live Demo -->
                <div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
                    <div class="so-form-group">
                        <label class="so-form-label" for="demo-start-time">Start Time</label>
                        <input type="time" class="so-form-control" id="demo-start-time" name="start_time">
                    </div>
                    <div class="so-form-group">
                        <label class="so-form-label" for="demo-end-time">End Time</label>
                        <input type="time" class="so-form-control" id="demo-end-time" name="end_time">
                    </div>
                </div>

                <!-- Code Tabs -->
                <?= so_code_tabs('time-range', [
                    [
                        'label' => 'PHP',
                        'language' => 'php',
                        'icon' => 'data_object',
                        'code' => "// Two separate time pickers
\$startTime = UiEngine::timePicker('start_time')
    ->label('Start Time');

\$endTime = UiEngine::timePicker('end_time')
    ->label('End Time');

// Or use time range component
\$timeRange = UiEngine::timeRange('schedule')
    ->label('Schedule')
    ->startName('start_time')
    ->endName('end_time');

echo \$timeRange->renderGroup();"
                    ],
                    [
                        'label' => 'JavaScript',
                        'language' => 'javascript',
                        'icon' => 'javascript',
                        'code' => "// Two separate time pickers
const startTime = UiEngine.timePicker('start_time')
    .label('Start Time');

const endTime = UiEngine.timePicker('end_time')
    .label('End Time');

// Or use time range component
const timeRange = UiEngine.timeRange('schedule')
    .label('Schedule')
    .startName('start_time')
    .endName('end_time')
    .onChange((start, end) => {
        console.log('Schedule:', start, 'to', end);
    });

document.getElementById('container').innerHTML = timeRange.toHtml();"
                    ],
                    [
                        'label' => 'HTML Output',
                        'language' => 'html',
                        'icon' => 'code',
                        'code' => '<div class="so-grid so-grid-cols-2 so-grid-cols-sm-1">
    <div class="so-form-group">
        <label class="so-form-label" for="start_time">Start Time</label>
        <input type="time" class="so-form-control" id="start_time" name="start_time">
    </div>
    <div class="so-form-group">
        <label class="so-form-label" for="end_time">End Time</label>
        <input type="time" class="so-form-control" id="end_time" name="end_time">
    </div>
</div>'
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
                        <h5 class="so-mt-3">Core\\UiEngine\\Elements\\Form\\TimePicker</h5>
                        <p class="so-text-muted">Extends FormElement</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine::timePicker(string $name)</code></td>
                                        <td>Create time picker with name</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Format Methods</h6>
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
                                        <td><code>hourFormat(int $format)</code></td>
                                        <td>Set hour format (12 or 24)</td>
                                    </tr>
                                    <tr>
                                        <td><code>hour12()</code></td>
                                        <td>Use 12-hour format with AM/PM</td>
                                    </tr>
                                    <tr>
                                        <td><code>hour24()</code></td>
                                        <td>Use 24-hour format (default)</td>
                                    </tr>
                                    <tr>
                                        <td><code>minuteStep(int $step)</code></td>
                                        <td>Set minute step interval (default: 5)</td>
                                    </tr>
                                    <tr>
                                        <td><code>showSeconds(bool $show = true)</code></td>
                                        <td>Show seconds selector</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Constraint Methods</h6>
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
                                        <td><code>minTime(string $time)</code></td>
                                        <td>Set minimum selectable time (e.g., '09:00')</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxTime(string $time)</code></td>
                                        <td>Set maximum selectable time (e.g., '17:00')</td>
                                    </tr>
                                    <tr>
                                        <td><code>timeRange(string $min, string $max)</code></td>
                                        <td>Set both min and max time</td>
                                    </tr>
                                    <tr>
                                        <td><code>businessHours()</code></td>
                                        <td>Shortcut for 9:00 - 17:00 range</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Feature Methods</h6>
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
                                        <td><code>clearable(bool $clearable = true)</code></td>
                                        <td>Show clear button (default: true)</td>
                                    </tr>
                                    <tr>
                                        <td><code>nowButton(bool $show = true)</code></td>
                                        <td>Show "Now" button (default: true)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Inherited Methods</h6>
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
                                        <td><code>id(string $id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>label(string $label)</code></td>
                                        <td>Set label text</td>
                                    </tr>
                                    <tr>
                                        <td><code>placeholder(string $text)</code></td>
                                        <td>Set placeholder text</td>
                                    </tr>
                                    <tr>
                                        <td><code>value(string $time)</code></td>
                                        <td>Set the time value</td>
                                    </tr>
                                    <tr>
                                        <td><code>required()</code></td>
                                        <td>Mark as required</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled()</code></td>
                                        <td>Disable the picker</td>
                                    </tr>
                                    <tr>
                                        <td><code>render()</code></td>
                                        <td>Render time picker HTML</td>
                                    </tr>
                                    <tr>
                                        <td><code>renderGroup()</code></td>
                                        <td>Render with form group wrapper</td>
                                    </tr>
                                    <tr>
                                        <td><code>toArray()</code></td>
                                        <td>Export configuration array</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- JS UiEngine Reference -->
                    <div class="so-tab-pane so-fade" id="api-js" role="tabpanel">
                        <h5 class="so-mt-3">UiEngine.timePicker()</h5>
                        <p class="so-text-muted">Extends FormElement</p>

                        <h6 class="so-mt-4">Constructor</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <tbody>
                                    <tr>
                                        <td><code>UiEngine.timePicker(name)</code></td>
                                        <td>Create time picker with name</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Format Methods</h6>
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
                                        <td><code>hourFormat(fmt)</code></td>
                                        <td>Set hour format (12 or 24)</td>
                                    </tr>
                                    <tr>
                                        <td><code>hour12()</code></td>
                                        <td>Use 12-hour format with AM/PM</td>
                                    </tr>
                                    <tr>
                                        <td><code>hour24()</code></td>
                                        <td>Use 24-hour format (default)</td>
                                    </tr>
                                    <tr>
                                        <td><code>minuteStep(step)</code></td>
                                        <td>Set minute step interval (default: 5)</td>
                                    </tr>
                                    <tr>
                                        <td><code>showSeconds(val = true)</code></td>
                                        <td>Show seconds selector</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Constraint Methods</h6>
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
                                        <td><code>minTime(time)</code></td>
                                        <td>Set minimum selectable time</td>
                                    </tr>
                                    <tr>
                                        <td><code>maxTime(time)</code></td>
                                        <td>Set maximum selectable time</td>
                                    </tr>
                                    <tr>
                                        <td><code>timeRange(min, max)</code></td>
                                        <td>Set both min and max time</td>
                                    </tr>
                                    <tr>
                                        <td><code>businessHours()</code></td>
                                        <td>Shortcut for 9:00 - 17:00 range</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Feature Methods</h6>
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
                                        <td><code>clearable(val = true)</code></td>
                                        <td>Show clear button (default: true)</td>
                                    </tr>
                                    <tr>
                                        <td><code>nowButton(val = true)</code></td>
                                        <td>Show "Now" button (default: true)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="so-mt-4">Inherited Methods</h6>
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
                                        <td><code>id(id)</code></td>
                                        <td>Set element ID</td>
                                    </tr>
                                    <tr>
                                        <td><code>label(label)</code></td>
                                        <td>Set label text</td>
                                    </tr>
                                    <tr>
                                        <td><code>placeholder(text)</code></td>
                                        <td>Set placeholder text</td>
                                    </tr>
                                    <tr>
                                        <td><code>value(time)</code></td>
                                        <td>Set the time value</td>
                                    </tr>
                                    <tr>
                                        <td><code>required()</code></td>
                                        <td>Mark as required</td>
                                    </tr>
                                    <tr>
                                        <td><code>disabled()</code></td>
                                        <td>Disable the picker</td>
                                    </tr>
                                    <tr>
                                        <td><code>attr(name, value)</code></td>
                                        <td>Set custom attribute</td>
                                    </tr>
                                    <tr>
                                        <td><code>data(key, value)</code></td>
                                        <td>Set data-* attribute</td>
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

                        <h6 class="so-mt-4">Events</h6>
                        <div class="so-table-responsive">
                            <table class="so-table so-table-bordered so-table-sm">
                                <thead class="so-table-light">
                                    <tr>
                                        <th style="width:40%">Event</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>change</code></td>
                                        <td>Fires when time is selected</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:timepicker:open</code></td>
                                        <td>Fires when picker opens</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:timepicker:close</code></td>
                                        <td>Fires when picker closes</td>
                                    </tr>
                                    <tr>
                                        <td><code>so:timepicker:clear</code></td>
                                        <td>Fires when time is cleared</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <h5 class="so-mt-6 so-mb-3">CSS Classes Reference</h5>
                <div class="so-table-responsive">
                    <table class="so-table so-table-bordered so-table-sm">
                        <thead class="so-table-light">
                            <tr>
                                <th style="width:40%">Class</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>.so-timepicker-wrapper</code></td>
                                <td>Wrapper for time picker component</td>
                            </tr>
                            <tr>
                                <td><code>.so-timepicker-input</code></td>
                                <td>Time input field</td>
                            </tr>
                            <tr>
                                <td><code>.so-timepicker-dropdown</code></td>
                                <td>Time selection dropdown</td>
                            </tr>
                            <tr>
                                <td><code>.so-timepicker-clear</code></td>
                                <td>Clear button</td>
                            </tr>
                            <tr>
                                <td><code>.so-form-control-sm</code></td>
                                <td>Small size variant</td>
                            </tr>
                            <tr>
                                <td><code>.so-form-control-lg</code></td>
                                <td>Large size variant</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>
