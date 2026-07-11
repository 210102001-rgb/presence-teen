---
name: Academic Clarity
colors:
  surface: '#f9f9f9'
  surface-dim: '#dadada'
  surface-bright: '#f9f9f9'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f3f3f3'
  surface-container: '#eeeeee'
  surface-container-high: '#e8e8e8'
  surface-container-highest: '#e2e2e2'
  on-surface: '#1a1c1c'
  on-surface-variant: '#3f493f'
  inverse-surface: '#2f3131'
  inverse-on-surface: '#f1f1f1'
  outline: '#6f7a6f'
  outline-variant: '#becabd'
  surface-tint: '#056d35'
  primary: '#005025'
  on-primary: '#ffffff'
  primary-container: '#006b33'
  on-primary-container: '#8fe9a3'
  inverse-primary: '#81da95'
  secondary: '#556158'
  on-secondary: '#ffffff'
  secondary-container: '#d9e6da'
  on-secondary-container: '#5b675e'
  tertiary: '#005111'
  on-tertiary: '#ffffff'
  tertiary-container: '#196b22'
  on-tertiary-container: '#97e990'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#9cf6af'
  primary-fixed-dim: '#81da95'
  on-primary-fixed: '#00210b'
  on-primary-fixed-variant: '#005226'
  secondary-fixed: '#d9e6da'
  secondary-fixed-dim: '#bdcabe'
  on-secondary-fixed: '#131e17'
  on-secondary-fixed-variant: '#3e4a41'
  tertiary-fixed: '#a3f69c'
  tertiary-fixed-dim: '#88d982'
  on-tertiary-fixed: '#002204'
  on-tertiary-fixed-variant: '#005312'
  background: '#f9f9f9'
  on-background: '#1a1c1c'
  surface-variant: '#e2e2e2'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  unit: 4px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  container-max: 1280px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 40px
---

## Brand & Style

The design system is anchored in the principles of **Modern Minimalism** tailored for educational environments. The personality is professional, efficient, and organized, ensuring that students, teachers, and parents can navigate complex academic data without cognitive overload.

The aesthetic prioritizes clarity through generous whitespace, a restricted color palette, and purposeful typography. It avoids unnecessary ornamentation, using structural alignment and subtle depth to guide the user's eye. The emotional response should be one of calm focus and institutional reliability—a digital extension of a well-organized campus.

## Colors

The palette is centered on a "Deep Green" primary color, symbolizing growth and institutional stability. 

- **Primary (#006B33):** Used for key actions, active states, and branding elements.
- **Secondary (#E8F5E9):** A soft green used for subtle highlights, success states, and progress indicators.
- **Neutral (#F5F5F5):** Reserved for card backgrounds and structural sections to separate content from the pure white page background.
- **Background (#FFFFFF):** The primary canvas, ensuring maximum contrast and a "breathable" interface.

Accessibility is paramount; all text pairings must meet WCAG AA standards, particularly the primary green against white backgrounds.

## Typography

The design system utilizes **Inter** for all roles to maintain a systematic and utilitarian feel. The typeface’s high x-height ensures excellent legibility for long-form educational content and dense data tables.

- **Headlines:** Use tighter letter spacing and heavier weights to create a strong visual hierarchy.
- **Body Text:** Standard weight (400) with generous line height to reduce eye strain during reading.
- **Labels:** Medium weights (500-600) used for navigation elements, buttons, and form headers to differentiate them from content text.

## Layout & Spacing

This design system follows an **8pt grid system** to ensure mathematical consistency across all components.

- **Grid Model:** A 12-column fluid grid for desktop and a 4-column grid for mobile.
- **Desktop:** 1280px max-width container with 24px gutters.
- **Mobile:** Full-width layout with 16px side margins to maximize screen real estate for information-dense views (like schedules).
- **Rhythm:** Vertical spacing between sections should scale in multiples of 8px (e.g., 24px, 32px, 48px) to maintain a clean, rhythmic flow.

## Elevation & Depth

To maintain a minimalist profile, depth is communicated through **Tonal Layering** supplemented by **Ambient Shadows**.

- **Level 0 (Background):** Pure white (#FFFFFF).
- **Level 1 (Cards/Surface):** Very light gray (#F5F5F5) with no shadow, used for secondary content or grouping.
- **Level 2 (Interactive Elements):** White cards with a subtle, diffused shadow (0px 4px 12px, 5% opacity black).
- **Level 3 (Modals/Popovers):** White surfaces with a more pronounced shadow (0px 12px 24px, 10% opacity black) to signify focus and separation from the main layout.

Outlines are rarely used except for form inputs, which utilize a 1px soft gray border to define boundaries without adding visual weight.

## Shapes

The shape language is consistently **Rounded**, striking a balance between professional geometry and a welcoming, modern feel.

- **Base Radius:** 8px (0.5rem) for small components like buttons and input fields.
- **Large Radius:** 16px (1rem) for main content cards and containers.
- **Extra Large Radius:** 24px (1.5rem) for decorative elements or specific mobile bottom-sheet handles.

Buttons and chips never use fully circular (pill) shapes, maintaining the organized, structured aesthetic of the system.

## Components

### Buttons
- **Primary:** Deep Green background, White text. High-contrast, 8px corner radius.
- **Secondary:** Soft Green background (#E8F5E9), Deep Green text. Used for less critical actions.
- **Tertiary:** Transparent background, Deep Green text with a subtle underline or icon.

### Input Fields
- 1px border (#E0E0E0), 8px corner radius. On focus, the border transitions to Deep Green with a 2px stroke. Labels are consistently placed above the field in `label-md`.

### Cards
- White background, 16px corner radius, and Level 2 ambient shadow. Use for individual course modules, grade summaries, or news items.

### Chips & Tags
- Used for course categories or status indicators (e.g., "In Progress"). Small 4px radius, using the secondary color palette.

### Lists
- Clean, borderless list items separated by 1px horizontal dividers (#F0F0F0). Large touch targets (min 48px height) for mobile accessibility.

### Icons
- Use minimalist line icons (2px stroke weight) to match the Inter typeface's weight. Icons should be monochrome (Deep Green or Dark Gray) to avoid distracting from the content.