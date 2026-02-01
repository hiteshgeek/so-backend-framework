<?php
/**
 * Diagram Component
 *
 * Renders visual flowcharts and architecture diagrams with consistent styling
 *
 * Usage:
 *   <?php render_diagram($nodes, $type, $title); ?>
 *
 * Parameters:
 *   $nodes - Array of diagram nodes
 *   $type - 'flow' (vertical flow), 'architecture' (layered), 'sequence' (horizontal flow)
 *   $title - Optional diagram title
 *
 * Node structure:
 *   [
 *       'id' => 'unique-id',
 *       'label' => 'Display Text',
 *       'sublabel' => 'Optional description', // optional
 *       'icon' => 'mdi-icon-name', // optional
 *       'type' => 'start|process|decision|endpoint', // affects styling
 *       'connects_to' => ['node-id-1', 'node-id-2'], // optional
 *   ]
 */

function render_diagram($nodes, $type = 'flow', $title = '') {
    $diagramId = 'diagram-' . uniqid();
    ?>
    <div class="diagram-container" data-type="<?= htmlspecialchars($type) ?>">
        <?php if ($title): ?>
            <div class="diagram-title">
                <span class="mdi mdi-sitemap"></span>
                <?= htmlspecialchars($title) ?>
            </div>
        <?php endif; ?>

        <div class="diagram-content <?= htmlspecialchars($type) ?>-diagram" id="<?= htmlspecialchars($diagramId) ?>">
            <?php foreach ($nodes as $node): ?>
                <div class="diagram-node <?= htmlspecialchars($node['type'] ?? 'process') ?>-node"
                     data-node-id="<?= htmlspecialchars($node['id']) ?>">

                    <?php if (!empty($node['icon'])): ?>
                        <div class="node-icon">
                            <span class="mdi <?= htmlspecialchars($node['icon']) ?>"></span>
                        </div>
                    <?php endif; ?>

                    <div class="node-content">
                        <div class="node-label"><?= htmlspecialchars($node['label']) ?></div>
                        <?php if (!empty($node['sublabel'])): ?>
                            <div class="node-sublabel"><?= htmlspecialchars($node['sublabel']) ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($node['connects_to'])): ?>
                        <div class="node-connector"></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

/**
 * Render a simple layered architecture diagram
 * Optimized for security layers, tech stack visualization
 */
function render_layered_diagram($layers, $title = '') {
    ?>
    <div class="layered-diagram-container">
        <?php if ($title): ?>
            <div class="diagram-title">
                <span class="mdi mdi-layers"></span>
                <?= htmlspecialchars($title) ?>
            </div>
        <?php endif; ?>

        <div class="layered-diagram">
            <?php foreach ($layers as $layer): ?>
                <div class="layer-item <?= htmlspecialchars($layer['style'] ?? '') ?>">
                    <div class="layer-header">
                        <?php if (!empty($layer['icon'])): ?>
                            <span class="mdi <?= htmlspecialchars($layer['icon']) ?>"></span>
                        <?php endif; ?>
                        <span class="layer-title"><?= htmlspecialchars($layer['title']) ?></span>
                    </div>
                    <?php if (!empty($layer['description'])): ?>
                        <div class="layer-description"><?= htmlspecialchars($layer['description']) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($layer['items'])): ?>
                        <div class="layer-items">
                            <?php foreach ($layer['items'] as $item): ?>
                                <span class="layer-tag"><?= htmlspecialchars($item) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($layer !== end($layers)): ?>
                    <div class="layer-connector">
                        <span class="mdi mdi-arrow-down"></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

/**
 * Render a simple flow diagram (vertical or horizontal)
 */
function render_flow_diagram($steps, $direction = 'vertical', $title = '') {
    ?>
    <div class="flow-diagram-container <?= htmlspecialchars($direction) ?>">
        <?php if ($title): ?>
            <div class="diagram-title">
                <span class="mdi mdi-chart-timeline-variant"></span>
                <?= htmlspecialchars($title) ?>
            </div>
        <?php endif; ?>

        <div class="flow-diagram">
            <?php foreach ($steps as $index => $step): ?>
                <div class="flow-step">
                    <div class="flow-step-number"><?= $index + 1 ?></div>
                    <div class="flow-step-content">
                        <div class="flow-step-title"><?= htmlspecialchars($step['title']) ?></div>
                        <?php if (!empty($step['description'])): ?>
                            <div class="flow-step-description"><?= htmlspecialchars($step['description']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($index < count($steps) - 1): ?>
                    <div class="flow-connector">
                        <span class="mdi <?= $direction === 'vertical' ? 'mdi-arrow-down' : 'mdi-arrow-right' ?>"></span>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
