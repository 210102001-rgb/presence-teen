---
timestamp: 2026-07-11T02-40-33Z
slug: resources-views-dashboard-siswa-blade-php
---
# User Experience and Interface Design Assessment Report
**Target Codebase:** Presence-Teen (Laravel 13, PHP 8.3, Livewire v4, Tailwind CSS v3)  
**Evaluated Files:**
* `D:\Kerja\Demo\presence-teen\resources\views\dashboard\siswa.blade.php`
* `D:\Kerja\Demo\presence-teen\resources\views\dashboard\guru.blade.php`
* `D:\Kerja\Demo\presence-teen\resources\views\dashboard\orang_tua.blade.php`
* `D:\Kerja\Demo\presence-teen\resources\views\layouts\app.blade.php`
* `D:\Kerja\Demo\presence-teen\resources\views\layouts\navigation.blade.php`
* `D:\Kerja\Demo\presence-teen\resources\views\presensi\scan.blade.php`
* `D:\Kerja\Demo\presence-teen\resources\views\livewire\qr-presensi.blade.php`

---

## 1. High-Level UX/UI Critiques

### Mobile Compatibility & Responsive Design
* **Fixed Navigation Lock:** The primary layouts (`layouts/app.blade.php` and `layouts/navigation.blade.php`) lock the sidebar to `w-64 fixed left-0 top-0` and offset the main content via `ml-64`. There is no mobile responsive drawer, sidebar toggle, or hamburger menu. On mobile viewports (e.g., iPhones/Androids with width under 768px), the sidebar takes up 256px of the screen, squeezing the main content container into a tiny, unreadable vertical strip.
* **Header Constraints:** The header element is styled with `w-[calc(100%-16rem)]` and `px-10`. On mobile devices, this calculation forces the header to overlap awkwardly and clip elements.
* **Actions Layout:** In `dashboard/guru.blade.php`, the upload action banner uses a simple `flex` layout with a `shrink-0` button. On small viewports, the text content gets severely squished because the flex layout does not wrap.

### Typography & Hierarchy
* **Font Consistency:** The application relies on `Inter` from Google Fonts, which fits the modern portal aesthetic. However, the sizing hierarchy drops off sharply: stats metrics jump from `text-4xl` directly to `text-[11px]` sub-headers.
* **Readability of Monospaced Tokens:** Monospaced elements like `Token: {{ $sesiAktif->qr_token }}` in the QR component are rendered in small, low-contrast text (`text-[#5c5f61]/70`), making them difficult for teachers to read on high-glare projectors or small screens.

### Layout & Cognitive Load
* **Stats Cards Inconsistency:** The first stat card in the dashboard grids has a full-color background (`bg-[#0e7a3d]` with light green text), while the subsequent cards use white backgrounds with dark text and colored top borders (`border-t-4`). This inconsistency draws disproportionate user attention to the first stat card, even when the second or third card contains more critical data (e.g., active warnings or urgent tasks).
* **Missing Fullscreen Option for QR:** Teachers need to project the QR code onto a classroom screen. The layout limits the QR code container to a small box. Without a fullscreen toggle, teachers must manually zoom in their browsers.

---

## 2. Style Inconsistencies and Clashing Visuals

### Clashing Border Patterns
* **Sidebar Active Border:** The active state in `navigation.blade.php` is styled with `border-l-4 border-[#97f7ac]`.
* **Stats Card Border:** The cards in the dashboards use a top-border highlight `border-t-4 border-[#005f2d]`.
* **Bento/Action Cards:** The quick-action cards are borderless or use a uniform border `border-[#eaeef2]` with no accent highlights.
* **Visual Result:** Within a single viewport, users see three distinct card-border styling systems, which fragments the visual language of the application.

### Border-Radius and Border-Left Collision
* In `navigation.blade.php`, the navigation links use `rounded-xl` alongside a sharp `border-l-4` highlight. This creates an awkward visual collision where a sharp vertical border block sits over a rounded container corner, resulting in a clipped appearance.

### Hardcoded Hex Colors vs. Custom Theme Tokens
* Although `tailwind.config.js` defines semantic color names (e.g., `primary`, `primary-container`, `on-surface`, `on-surface-variant`, `error-container`), the Blade views bypass them. Instead of utilizing classes like `bg-primary-container` or `text-on-surface`, the views use hardcoded classes such as `bg-[#0e7a3d]`, `text-[#171c1f]`, and `bg-[#ffdad6]`. This compromises theme manageability and makes the application harder to maintain.

### Interaction Model Discrepancy
* The action cards on the Guru dashboard use the transition class `bento-card` (which translates upward by `-2px` and deepens the shadow on hover). The action cards on the Siswa and Orang Tua dashboards are styled identically but lack this class, creating inconsistent feedback for identical interactive elements.

---

## 3. Ten Nielsen Heuristics Evaluation

### 1. Visibility of System Status
* **Score:** `1/4` (Cosmetic/Minor Usability Problem)
* **Rationale:** The active QR session has a pulsing status dot. However, there is no countdown timer or progress indicator showing when the token will next rotate (it only states "Auto-refresh tiap 5s"). Students scanning the code cannot tell if the token is about to expire, leading to failed scans right as they attempt them.

### 2. Match Between System and Real World
* **Score:** `4/4` (No usability problem)
* **Rationale:** The terminology fits the school environment ("Mata Pelajaran", "Mendesak", "Presensi"). Icons correspond directly to their physical meanings (e.g., a book icon for learning materials, an assignment icon for homework).

### 3. User Control and Freedom
* **Score:** `2/4` (Minor Usability Problem)
* **Rationale:** There is a manual token input fallback if the camera scanner fails. However, there is no way to cancel, restart, or pause a camera scan once it fails or finishes. Additionally, teachers cannot pause the 5-second QR rotation to allow a struggling student to finish scanning.

### 4. Consistency and Standards
* **Score:** `1/4` (Major Usability Problem)
* **Rationale:** The style guide guidelines defined in `AGENTS.md` are bypassed by using raw hex values. The mix of `border-l-4` on active sidebar links, `border-t-4` on metrics cards, and borderless bento cards creates visual fragmentation.

### 5. Error Prevention
* **Score:** `2/4` (Minor Usability Problem)
* **Rationale:** The "Akhiri Sesi Presensi" button on the teacher dashboard is a high-consequence action that ends the session for all students. It is styled in red but lacks any confirmation dialog. A teacher could easily click this accidentally on a mobile interface, terminating the session immediately.

### 6. Recognition Rather Than Recall
* **Score:** `1/4` (Major Usability Problem)
* **Rationale:** On `dashboard/orang_tua.blade.php`, the parent dashboard displays a list of outstanding tasks. However, if a task is unsubmitted, the system displays "Belum dikumpulkan" but **does not print the name of the child** it belongs to. For parents with multiple children enrolled in the school, they are forced to recall which class and child match the task title, or search through other screens.

### 7. Flexibility and Efficiency of Use
* **Score:** `2/4` (Minor Usability Problem)
* **Rationale:** While the auto-submit URL mechanism accelerates scanning, there are no dashboard shortcuts or keyboard navigation options for frequent teacher tasks (like quickly re-displaying the active QR session from the home screen).

### 8. Aesthetic and Minimalist Design
* **Score:** `2/4` (Minor Usability Problem)
* **Rationale:** The typography and use of whitespace are generally clean. However, the visual noise caused by inconsistent cards, mixed border patterns, and hardcoded colors makes the screens look cluttered and less cohesive.

### 9. Help Users Recognize, Diagnose, and Recover from Errors
* **Score:** `1/4` (Cosmetic/Minor Usability Problem)
* **Rationale:** If camera access fails on the scanner page, the system output is: "Kamera tidak dapat diakses. Gunakan input manual." It does not provide actionable instructions on how to resolve the error, such as checking browser permissions or checking if another application is using the camera.

### 10. Help and Documentation
* **Score:** `2/4` (Minor Usability Problem)
* **Rationale:** Weekly AI Insights are displayed to parents, but there is no documentation explaining how these warnings ("kritis", "perhatian") are calculated or what parameters trigger them.

---

## 4. Persona Walkthrough Tests

### Persona 1: Alex (Student)
* **Objective:** Scan the QR code at the start of class and check homework deadlines.
* **Red Flags:**
  * The sidebar layout is broken. The `w-64 fixed` menu overlaps the main content on mobile screens, hiding the "Buka Scanner" button.
  * Camera starts. The scanner target box has a hardcoded `max-width: 380px` style which overflows the view on smaller phones.
  * The scan completes, and the page reloads. Alex looks at "Tugas Mendatang" and sees a task marked "Mendesak", but the view does not show the remaining hours, only the absolute deadline timestamp.

### Persona 2: Jordan (Teacher)
* **Objective:** Start a Math class session, project the QR code, and monitor attendance.
* **Red Flags:**
  * The QR code container is small (`size(240)`). Jordan must zoom the web browser so that students at the back of the classroom can scan it.
  * The QR token rotates every 5 seconds. Several students at the back complain that their phones fail to scan because the code changes before their cameras can focus. Jordan has no way to pause the rotation or extend the duration.
  * Jordan goes to scroll down and accidentally clicks the red "Akhiri Sesi Presensi" button. The session is instantly deleted without warning, forcing Jordan to recreate it.

### Persona 3: Casey (Parent)
* **Objective:** Check if both children (Taylor and Morgan) have completed their assignments.
* **Red Flags:**
  * Sees "Tugas Matematika - Belum dikumpulkan". Casey does not know if this is Morgan's task or Taylor's task, because the student's name is omitted for incomplete tasks.
  * Sees a red indicator warning: "Status Kritis! Perlu tindakan segera terhadap kehadiran/tugas anak Anda." The warning does not specify which child is in a critical status. Casey has to navigate to the detailed report screens to find out.

---

## 5. Priority Issues and Technical Recommendations

### P0: Broken Mobile Responsive Layout (Layout & Mobile Compatibility)
* **Why it matters:** High. Users cannot access dashboard features on mobile devices because the fixed sidebar blocks the content.
* **Fix:**
  * Implement an Alpine.js open/close state on the layout.
  * Hide the sidebar by default on mobile devices (`-translate-x-full lg:translate-x-0`) and add a toggle button to the top header.
  * Change the main content padding offset from `ml-64` to `lg:ml-64 ml-0`.
* **Suggested command:** `/impeccable adapt`

### P1: Missing Student Attribution on Parent Dashboard (Recognition vs. Recall)
* **Why it matters:** High. Parents with multiple children cannot distinguish who incomplete assignments belong to.
* **Fix:** Update the incomplete list item logic to display the student's name, mirroring the completed items layout.
* **Suggested command:** `/impeccable clarify`

### P2: Standardizing Raw Colors to Custom Tailwind Tokens (Consistency)
* **Why it matters:** Medium. Using raw hex codes instead of configured tokens breaks theme extensibility.
* **Fix:** Replace the hardcoded hex codes with the matching Material Design 3 tokens defined in `tailwind.config.js`.
* **Suggested command:** `/impeccable polish`

### P3: Missing Destructive Action Warning (Error Prevention)
* **Why it matters:** Medium. Accidental session termination disrupts the classroom.
* **Fix:** Add a Livewire confirmation dialog directly to the action button trigger.
* **Suggested command:** `/impeccable harden`
