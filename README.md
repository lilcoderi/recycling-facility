# Recycling Facility Directory

This Laravel application serves as a comprehensive directory for recycling facilities, allowing for efficient management of facility information, including accepted materials, last update dates, and addresses. It features robust search, filter, and sorting capabilities, along with user authentication and data export.

---

## Objective
The primary objective of this application is to provide a web-based platform for managing a directory of recycling facilities. Users can easily add new facilities, update existing ones, delete obsolete entries, and explore facility details. The system also supports advanced querying and data extraction.

---

## Features

### Facility Management (CRUD)
- Add new recycling facilities with details like business name, last update date, street address, and accepted materials.
- Edit existing facility information.
- Delete facilities from the directory.

### Material Management (CRUD)
- Manage a list of available materials (e.g., "Plastics", "Paper", "Glass", "Electronics").
- Add, edit, and delete material types.

### Paginated Listing
- Facilities are displayed in a paginated table for better readability and performance.

### Search Functionality
- Search facilities by business name, street address, or material name.

### Sorting
- Sort facilities by `last_update_date` (defaulting to descending order).

### Filtering
- Filter facilities based on the materials they accept using a dropdown selector.

### Facility Detail Page
- Displays all information for a specific facility.
- Includes an embedded Google Map showing the facility's location based on its street address.

### CSV Export
- Export currently filtered/searched facility results into a downloadable CSV file.

### User Authentication (Bonus)
- Only logged-in users can access and manage the facility and material directories.
- Secure login and registration system.

### Sidebar Navigation
- Clean, collapsible sidebar for improved user experience and navigation.

### Icon-based Actions
- Replaced text-based "View", "Edit", and "Delete" buttons with intuitive icons.

### Checkbox Material Selection
- When adding/editing facilities, materials are selected via checkboxes.

---

## Database Design & Relationships

The application uses a **MySQL** database with three tables to manage facilities and materials, establishing a many-to-many relationship between them.

### **facilities table**
- `id` (Primary Key, Auto-increment)
- `business_name` (VARCHAR): Name of the recycling facility.
- `last_update_date` (DATE): The last date the facility's information was updated.
- `street_address` (TEXT): Full street address of the facility.

### **materials table**
- `id` (Primary Key, Auto-increment)
- `name` (VARCHAR): Name of the material (e.g., "Plastics", "Paper").

### **facility_material** (Pivot Table)
- Handles the many-to-many relationship between facilities and materials.
- A facility can accept multiple materials, and a material can be accepted by multiple facilities.
- `facility_id` (Foreign Key → facilities.id)
- `material_id` (Foreign Key → materials.id)
- Includes `created_at` and `updated_at` timestamps for tracking.

**Relationship Implementation:**
```php
// Facility.php
public function materials()
{
    return $this->belongsToMany(Material::class);
}

// Material.php
public function facilities()
{
    return $this->belongsToMany(Facility::class);
}
```
---

## Implementation Details

### CRUD Operations
- **Facilities**: Managed via `FacilityController` (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`).
  - Validation implemented using Laravel's built-in **request validation**.
  - Materials are linked to facilities using the `sync()` method on the many-to-many relationship.
  
- **Materials**: Managed via `MaterialController` with full CRUD functionality.

---

### Listing Facilities
- **Pagination**: Implemented using `paginate(10)` to limit the results per page.
- **Search**: Allows searching by `business_name`, `street_address`, and `material.name` using `where` and `orWhereHas` Eloquent queries.
- **Sorting**: Controlled by a `sort` request parameter (`asc` or `desc`) applied to `last_update_date` (defaults to descending order).
- **Filtering**: A `material_id` request parameter is used with `whereHas` to filter facilities that accept a specific material.

---

### Facility Detail Page
- Displays complete facility information and its related materials.
- Includes a **Google Maps embed** using the facility's `street_address` inside an `<iframe>`.

---

### CSV Export
- Exports the **currently filtered/searched** facility results into a CSV file.
- The exported file includes:
  - **Business Name**
  - **Last Updated**
  - **Address**
  - **Materials Accepted** (comma-separated list)

---

### Authentication
- Implemented with **Laravel Breeze** for registration, login, and logout.
- Routes are protected using the `auth` middleware to ensure that **only authenticated users** can access facility and material management features.

---

**Author**: Riana Nur Anisa
