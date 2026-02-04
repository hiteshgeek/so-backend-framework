# DataTable Plugin

A powerful, feature-rich data table plugin built with Tabulator and Material UI styling. Uses Google Sans font and Material Design components for a consistent, modern user interface.

## Features

- **Column Selection**: Show/hide columns using floating dropdown menu with sticky Apply button, column count badge, and selection counter
- **Multi-Column Grouping**: Group data by one or multiple columns with drag-and-drop ordering, checkbox selection, sticky Apply button, and grouping order display
- **Search**: Real-time search across all columns
- **Modern Pagination**: Material UI-styled pagination with configurable page sizes (default: 50 rows)
- **CSV Export**: Download data as CSV
- **URL Data Fetching**: Load data from API endpoints with filter support
- **Material UI Styling**: Google Sans font and Material Design components matching Group Summary plugin
- **Responsive Design**: Works on all screen sizes
- **Row Click Callbacks**: Handle row clicks with custom logic
- **Floating Dropdowns**: Clean UI with dropdowns instead of inline panels
- **Viewport Height Management**: Table adjusts to visible screen height with sticky headers and footers always visible
- **Footer Totals**: Client-side or server-side calculated totals row with proper column alignment
- **Cell Spacing Options**: Choose between compact, normal, or comfortable spacing for optimal readability
- **Row Expand/Collapse**: Expandable rows with + icon to load and display detailed HTML content below each row
- **Bulk Actions with More Menu**: Multi-row selection with bulk operations toolbar featuring overflow menu
- **Row Actions Menu**: Per-row actions dropdown with smart positioning

## Installation

Include the required dependencies:

```html
<!-- Google Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

<!-- Tabulator CSS -->
<link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">

<!-- Common & Plugin Styles -->
<link rel="stylesheet" href="../../common/sixorbit-common.css">
<link rel="stylesheet" href="datatable.css">

<!-- Tabulator JS -->
<script src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>

<!-- Plugin JavaScript -->
<script src="datatable.js"></script>
```

## Basic Usage

```javascript
const dataTable = new DataTable('container-id', {
    columns: [
        { title: "Name", field: "name" },
        { title: "Email", field: "email" },
        { title: "Department", field: "department" }
    ],
    data: [
        { name: "John Doe", email: "john@example.com", department: "Sales" },
        { name: "Jane Smith", email: "jane@example.com", department: "Marketing" }
    ]
});
```

## Loading Data from URL

```javascript
const dataTable = new DataTable('container-id', {
    columns: sampleColumns,
    dataUrl: 'https://api.example.com/employees',
    filters: {
        department: 'Sales',
        status: 'Active',
        minSalary: 50000
    }
});
```

## Configuration Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `columns` | Array | `[]` | Column definitions |
| `data` | Array | `null` | Data array (alternative to dataUrl) |
| `dataUrl` | String | `null` | API endpoint to fetch data |
| `filters` | Object | `{}` | Filters to pass to API |
| `height` | String | `null` | Table height (null = auto-expand with data) |
| `layout` | String | `'fitData'` | Table layout mode ('fitData' or 'fitColumns') |
| `pagination` | Boolean | `true` | Enable pagination |
| `paginationSize` | Number | `50` | Rows per page |
| `paginationSizeSelector` | Array | `[10,25,50,100,200]` | Page size options |
| `groupBy` | String/Array | `null` | Column(s) to group by (string for single, array for multiple) |
| `enableColumnSelection` | Boolean | `true` | Show/hide columns feature with Apply button |
| `enableSearch` | Boolean | `true` | Search feature |
| `enableGrouping` | Boolean | `true` | Multi-column grouping feature with Apply button |
| `showFooter` | Boolean | `false` | Show footer row with totals |
| `calcFooterTotals` | Boolean | `true` | Auto-calculate totals from data (true) or use server-side totals (false) |
| `footerTotals` | Object | `null` | Server-side totals (object with field names as keys) |
| `cellSpacing` | String | `'normal'` | Cell spacing: 'compact', 'normal', or 'comfortable' |
| `onRowClick` | Function | `null` | Row click callback |

## Footer Totals

### Client-Side Calculation (Auto-calculate from data)

```javascript
const dataTable = new DataTable('container-id', {
    columns: sampleColumns,
    data: sampleTableData,
    showFooter: true,
    calcFooterTotals: true  // Automatically calculate totals from all data
});
```

### Server-Side Totals (Use pre-calculated totals)

```javascript
const dataTable = new DataTable('container-id', {
    columns: sampleColumns,
    data: sampleTableData,
    showFooter: true,
    calcFooterTotals: false,  // Don't calculate, use provided totals
    footerTotals: {
        salary: 7500000,
        bonus: 1250000,
        experience: 625,
        age: 3650,
        hoursPerWeek: 4200,
        teamSize: 850
    }
});
```

## Column Format

```javascript
{
    title: "Salary",
    field: "salary",
    formatter: "money",
    formatterParams: { symbol: "$", precision: 0 },
    width: 120
}
```

See [Tabulator Documentation](https://tabulator.info/docs/5.5/columns) for all column options.

## Column Selection UI

The column selection dropdown provides an intuitive interface for showing/hiding columns:

- **Column Count Badge**: The Columns button displays a badge showing the number of selected columns
- **Selection Counter**: Inside the dropdown header, see "X of Y selected" to track your selection
- **Sticky Apply Button**: The Apply button remains visible at the bottom while scrolling through many columns
- **Interactive Selection**: Check/uncheck columns and see the count update in real-time
- **Active State Indicator**: The Columns button remains highlighted (blue) when some columns are hidden, providing a visual cue that column filtering is active

## Cell Spacing

Control the density of your table with the `cellSpacing` option:

```javascript
const dataTable = new DataTable('container-id', {
    columns: sampleColumns,
    data: sampleTableData,
    cellSpacing: 'compact'  // 'compact', 'normal', or 'comfortable'
});
```

- **compact**: Smaller padding (6px 12px), 12px font, 1.3 line-height - fits more data
- **normal**: Default padding (12px 16px), 13px font, 1.5 line-height - balanced view
- **comfortable**: Larger padding (16px 20px), 14px font, 1.6 line-height - easier reading

## Multi-Column Grouping with Drag-and-Drop Ordering

Group data by multiple columns for hierarchical organization. The grouping order matters - the first column is the primary grouping, second is nested within the first, etc.

### Programmatic Grouping

```javascript
const dataTable = new DataTable('container-id', {
    columns: sampleColumns,
    data: sampleTableData,
    groupBy: ['department', 'position']  // Array for multi-column grouping
});
```

### Interactive Grouping

Users can interactively configure grouping via the Group By dropdown:

1. **Select Columns**: Check columns from the "Available Columns" list
2. **Reorder Groups**: Drag and drop items in the "Grouping Order" section to change hierarchy
3. **Remove Groups**: Click the × button on any group in the order list
4. **Apply**: Click the sticky Apply button at the bottom to apply the grouping

**UI Features**:
- **Sticky Grouping Order**: The grouping order section stays at the top while scrolling through available columns
- **Sticky Apply Button**: The Apply button remains visible at the bottom while scrolling
- **Numbered Badges**: Each group shows its hierarchy level (1, 2, 3...)
- **Drag Handle**: Use the ☰ icon to drag and reorder groups
- **Active State Indicator**: The Group By button remains highlighted (blue) when grouping is active, providing a visual cue that data is grouped

## Row Expand/Collapse

Enable expandable rows to show detailed information below each row. Perfect for displaying additional details, related records, or complex nested data.

### Basic Setup

```javascript
const dataTable = new DataTable('container-id', {
    columns: sampleColumns,
    data: sampleTableData,
    enableRowExpand: true,  // Enable the expand feature
    onRowExpand: function(rowData, callback) {
        // Build your HTML content
        const content = `
            <div class="dt-expand-content">
                <h3>Details for ${rowData.name}</h3>
                <p>Additional information here...</p>
            </div>
        `;

        // Call the callback with the HTML
        callback(content);
    }
});
```

### Simple Synchronous Example

```javascript
onRowExpand: function(rowData, callback) {
    const content = `
        <div class="dt-expand-content">
            <h3>Employee Details - ${rowData.name}</h3>
            <div class="dt-detail-grid">
                <div class="dt-detail-item">
                    <span class="dt-detail-label">Employee Code</span>
                    <span class="dt-detail-value">${rowData.employeeCode}</span>
                </div>
                <div class="dt-detail-item">
                    <span class="dt-detail-label">Email</span>
                    <span class="dt-detail-value">${rowData.email}</span>
                </div>
                <div class="dt-detail-item">
                    <span class="dt-detail-label">Phone</span>
                    <span class="dt-detail-value">${rowData.phone}</span>
                </div>
            </div>
            <div class="dt-expand-actions">
                <button class="dt-expand-action-btn" onclick="viewProfile(${rowData.id})">
                    <span class="material-symbols-rounded">person</span>
                    View Profile
                </button>
                <button class="dt-expand-action-btn" onclick="editRecord(${rowData.id})">
                    <span class="material-symbols-rounded">edit</span>
                    Edit
                </button>
            </div>
        </div>
    `;
    callback(content);
}
```

### AJAX/Fetch Example

Load detailed data from your API when a row is expanded:

```javascript
onRowExpand: function(rowData, callback) {
    // Show loading indicator
    callback('<div class="dt-expand-content"><p>Loading...</p></div>');

    // Fetch detailed data from API
    fetch('/api/employees/' + rowData.id + '/details')
        .then(response => response.json())
        .then(data => {
            const content = `
                <div class="dt-expand-content">
                    <h3>Additional Details (Loaded via AJAX)</h3>
                    <div class="dt-detail-grid">
                        <div class="dt-detail-item">
                            <span class="dt-detail-label">Performance Score</span>
                            <span class="dt-detail-value">${data.performanceScore}%</span>
                        </div>
                        <div class="dt-detail-item">
                            <span class="dt-detail-label">Projects</span>
                            <span class="dt-detail-value">${data.projects.join(', ')}</span>
                        </div>
                        <div class="dt-detail-item">
                            <span class="dt-detail-label">Team Members</span>
                            <span class="dt-detail-value">${data.teamMembers.length}</span>
                        </div>
                        <div class="dt-detail-item">
                            <span class="dt-detail-label">Last Activity</span>
                            <span class="dt-detail-value">${new Date(data.lastActivity).toLocaleDateString()}</span>
                        </div>
                    </div>
                </div>
            `;
            callback(content);
        })
        .catch(error => {
            callback('<div class="dt-expand-content"><p style="color: #d93025;">Error loading details</p></div>');
        });
}
```

### jQuery AJAX Example

```javascript
onRowExpand: function(rowData, callback) {
    $.ajax({
        url: '/api/employee-details',
        method: 'GET',
        data: { employeeId: rowData.id },
        success: function(response) {
            const content = `
                <div class="dt-expand-content">
                    <h3>${response.title}</h3>
                    <div class="dt-detail-grid">
                        ${response.fields.map(field => `
                            <div class="dt-detail-item">
                                <span class="dt-detail-label">${field.label}</span>
                                <span class="dt-detail-value">${field.value}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
            callback(content);
        },
        error: function() {
            callback('<div class="dt-expand-content">Failed to load data</div>');
        }
    });
}
```

### Nested Table Example

Display a child table within the expanded row:

```javascript
onRowExpand: function(rowData, callback) {
    fetch('/api/employees/' + rowData.id + '/history')
        .then(response => response.json())
        .then(history => {
            const content = `
                <div class="dt-expand-content">
                    <h3>Employment History</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f8f9fa; text-align: left;">
                                <th style="padding: 8px; border-bottom: 2px solid #e8eaed;">Date</th>
                                <th style="padding: 8px; border-bottom: 2px solid #e8eaed;">Position</th>
                                <th style="padding: 8px; border-bottom: 2px solid #e8eaed;">Department</th>
                                <th style="padding: 8px; border-bottom: 2px solid #e8eaed;">Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${history.map(record => `
                                <tr style="border-bottom: 1px solid #e8eaed;">
                                    <td style="padding: 8px;">${record.date}</td>
                                    <td style="padding: 8px;">${record.position}</td>
                                    <td style="padding: 8px;">${record.department}</td>
                                    <td style="padding: 8px;">$${record.salary.toLocaleString()}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
            callback(content);
        });
}
```

### Pre-styled CSS Classes

The plugin provides pre-styled CSS classes for consistent expand content:

- **`.dt-expand-content`**: Main container with padding
- **`.dt-detail-grid`**: Responsive grid layout for detail items
- **`.dt-detail-item`**: Individual detail item container
- **`.dt-detail-label`**: Label styling (uppercase, gray)
- **`.dt-detail-value`**: Value styling
- **`.dt-expand-actions`**: Action buttons container
- **`.dt-expand-action-btn`**: Styled action button

## API Methods

### setData(data)

Update table data.

```javascript
dataTable.setData(newData);
```

### setFilters(filters)

Update filters and reload data from URL.

```javascript
dataTable.setFilters({
    department: 'IT',
    status: 'Active'
});
```

## Events

### onRowClick(rowData)

Called when a row is clicked.

```javascript
onRowClick: function(rowData) {
    console.log('Row clicked:', rowData);
}
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Example

See `index.html` for a complete working example with sample data.
