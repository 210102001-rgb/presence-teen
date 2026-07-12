---
name: Presence Teen Desktop
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#3f493f'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#6f7a6e'
  outline-variant: '#becabc'
  surface-tint: '#006d30'
  primary: '#00652c'
  on-primary: '#ffffff'
  primary-container: '#15803d'
  on-primary-container: '#d3ffd5'
  inverse-primary: '#79db8d'
  secondary: '#006e2d'
  on-secondary: '#ffffff'
  secondary-container: '#7cf994'
  on-secondary-container: '#007230'
  tertiary: '#6e5300'
  on-tertiary: '#ffffff'
  tertiary-container: '#8c6a00'
  on-tertiary-container: '#fff2dd'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#95f8a7'
  primary-fixed-dim: '#79db8d'
  on-primary-fixed: '#00210a'
  on-primary-fixed-variant: '#005323'
  secondary-fixed: '#7ffc97'
  secondary-fixed-dim: '#62df7d'
  on-secondary-fixed: '#002109'
  on-secondary-fixed-variant: '#005320'
  tertiary-fixed: '#ffdf9a'
  tertiary-fixed-dim: '#f7be1d'
  on-tertiary-fixed: '#251a00'
  on-tertiary-fixed-variant: '#5a4300'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  headline-lg:
    fontFamily: Poppins
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Poppins
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  title-lg:
    fontFamily: Poppins
    fontSize: 20px
    fontWeight: '500'
    lineHeight: 28px
  title-md:
    fontFamily: Poppins
    fontSize: 16px
    fontWeight: '500'
    lineHeight: 24px
  body-lg:
    fontFamily: Poppins
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Poppins
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-sm:
    fontFamily: Poppins
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.05em
  caption:
    fontFamily: Poppins
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 16px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  unit: 8px
  container-padding: 32px
  gutter: 24px
  sidebar-width: 280px
  card-padding: 24px
---

## Brand & Style
The design system facilitates a seamless transition for the "Presence Teen" platform from mobile-first to a comprehensive desktop experience. The brand personality is professional, encouraging, and academically focused, designed to resonate with both students and school administrators.

The style is **Corporate / Modern** with a distinct SaaS aesthetic. It prioritizes clarity and efficiency through a high-order layout, utilizing generous whitespace and a "soft-edge" philosophy. By translating the mobile app's friendliness into a structured desktop environment, the design system ensures reliability without feeling institutional or dated. Key characteristics include high-legibility typography, clear status signaling, and an approachable interface that simplifies administrative complexity.

## Colors
The palette is rooted in a spectrum of greens to symbolize growth and academic vitality. 

- **Primary Green (#15803D):** Reserved for primary actions, navigation headers, and key emphasis.
- **Secondary Green (#16A34A):** Used for hover states and secondary active elements.
- **Light Green (#DCFCE7):** Applied as a background for chips, badges, and selected card states to maintain a soft visual footprint.
- **Accent Yellow (#EAB308):** Sourced from the school logo, this is used sparingly as a "high-attention" color for alerts, special badges (e.g., "Late"), or specific icon highlights.
- **Neutral/Background:** The background uses a cool slate tint (#F8FAFC) to separate the canvas from white (#FFFFFF) surface cards, while borders remain subtle to maintain a "borderless" feel.

## Typography
Poppins is utilized across all levels to maintain the friendly yet structured tone found in the mobile reference. 

- **Headlines:** Use SemiBold (600) weights with tighter letter spacing for a modern, impactful look.
- **Subtitles/Titles:** Use Medium (500) weights to provide clear hierarchy within cards and tables.
- **Body Text:** Standardized at 14px (md) and 16px (lg) for optimal readability on desktop displays.
- **Labels:** Uppercase styles with slight tracking are used for secondary metadata or table headers to distinguish them from interactive data.

## Layout & Spacing
The layout follows a **Fixed Sidebar / Fluid Content** model optimized for desktop viewing. 

- **Sidebar:** A permanent 280px left-hand navigation column contains the logo and primary navigation links.
- **Topbar:** A slim header provides breadcrumbs, search, and user profile access.
- **Grid:** Content is organized in a responsive 12-column grid. On desktop, cards typically span 3, 4, 6, or 12 columns depending on data density.
- **Rhythm:** An 8px base unit governs all spacing. Generous internal padding (24px) within containers ensures the "minimalist" feel and prevents the UI from appearing cluttered during data-heavy tasks.

## Elevation & Depth
This design system uses a **Tonal Layering** approach combined with **Ambient Shadows**. 

Depth is established by placing white surfaces (#FFFFFF) on a light grey-blue background (#F8FAFC). To give the UI the "SaaS feel," cards and modals utilize an extra-diffused shadow:
- **Shadow-SM:** 0 1px 3px rgba(0,0,0,0.1) — used for small buttons and input focus.
- **Shadow-MD:** 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06) — the default for dashboard cards.
- **Shadow-LG:** 0 10px 15px -3px rgba(0,0,0,0.1) — reserved for modals and dropdown menus.

Borders are used primarily for structure (tables, input fields) using a low-contrast #E2E8F0 to maintain a soft aesthetic.

## Shapes
The design system features a "Hyper-Rounded" characteristic to mirror the approachable nature of the mobile app. 

- **Standard Radius:** 16px for all primary cards, buttons, and input fields.
- **Large Radius:** 24px for large containers or promotional banners.
- **Pill Radius:** Used for status badges and tags (e.g., "Present", "Excused").
This consistent rounding softens the "corporate" edge of the desktop layout, making the software feel modern and student-friendly.

## Components

### Buttons
- **Primary:** Solid #15803D with white text. 16px radius.
- **Secondary:** Light Green #DCFCE7 background with #15803D text.
- **Outline:** Transparent background, #E2E8F0 border, #15803D text.
- **Ghost:** No background or border; appears on hover.

### Tables
Clean, borderless-first tables. Headers use `label-sm` typography with a light grey background. Rows have a subtle hover state (#F8FAFC). Statuses (Present, Absent, Late) are displayed as pill-shaped chips with background tints.

### Inputs & Selects
16px rounded corners with a 1px #E2E8F0 border. On focus, the border transitions to Primary Green with a soft outer glow. Icons within inputs should be 20px outline-style icons.

### Cards
White background, 16px radius, and `Shadow-MD`. Cards should have a consistent 24px internal padding.

### Navigation
- **Sidebar:** Primary Green active states with a vertical indicator bar on the left.
- **Topbar:** Features a search bar with 16px rounding and a user profile avatar.

### Data Visualization
Charts should use the Primary Green, Secondary Green, and Accent Yellow palette. Use soft, rounded line ends and sans-serif labels to match the typography system.

### QR Components
The QR code is housed in a dedicated card with 16px padding, centered, with a descriptive label above it and a "Download/Print" secondary button below.