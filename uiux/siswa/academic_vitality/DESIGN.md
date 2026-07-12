---
name: Academic Vitality
colors:
  surface: '#f8f9fa'
  surface-dim: '#d9dadb'
  surface-bright: '#f8f9fa'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f3f4f5'
  surface-container: '#edeeef'
  surface-container-high: '#e7e8e9'
  surface-container-highest: '#e1e3e4'
  on-surface: '#191c1d'
  on-surface-variant: '#3e4a3c'
  inverse-surface: '#2e3132'
  inverse-on-surface: '#f0f1f2'
  outline: '#6e7b6b'
  outline-variant: '#bdcab9'
  surface-tint: '#006e25'
  primary: '#006e25'
  on-primary: '#ffffff'
  primary-container: '#28a745'
  on-primary-container: '#00330d'
  inverse-primary: '#66df75'
  secondary: '#695f00'
  on-secondary: '#ffffff'
  secondary-container: '#f9e534'
  on-secondary-container: '#706500'
  tertiary: '#5b5f63'
  on-tertiary: '#ffffff'
  tertiary-container: '#8e9297'
  on-tertiary-container: '#272b2f'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#83fc8e'
  primary-fixed-dim: '#66df75'
  on-primary-fixed: '#002106'
  on-primary-fixed-variant: '#00531a'
  secondary-fixed: '#f9e534'
  secondary-fixed-dim: '#dbc90a'
  on-secondary-fixed: '#201c00'
  on-secondary-fixed-variant: '#4f4800'
  tertiary-fixed: '#e0e3e8'
  tertiary-fixed-dim: '#c3c7cc'
  on-tertiary-fixed: '#181c20'
  on-tertiary-fixed-variant: '#43474c'
  background: '#f8f9fa'
  on-background: '#191c1d'
  surface-variant: '#e1e3e4'
typography:
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 26px
  body-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 28px
    fontWeight: '700'
    lineHeight: 36px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  xs: 4px
  sm: 12px
  md: 16px
  lg: 24px
  xl: 32px
  margin-mobile: 20px
  gutter-mobile: 12px
---

## Brand & Style
The design system is built on a foundation of **Modern Professionalism** with a **Youthful Energy**. It serves a dual audience: teenagers who require an engaging, low-friction interface, and parents/educators who demand reliability and clarity. 

The aesthetic is characterized by clean whitespace, high-legibility typography, and a "Soft Tech" feel. We avoid the clinical coldness of traditional enterprise software by using generous corner radii and soft, ambient depth. The mood is optimistic and organized, encouraging students to take ownership of their presence and academic progress.

## Colors
The palette is derived directly from the institutional heritage of the logo, re-interpreted for high-digital accessibility.

- **Primary (Green):** Representing growth and "active" status. Used for main actions, success states, and primary branding elements.
- **Secondary (Yellow):** Used sparingly as an accent for notifications, highlights, or "attention-required" status. Ensure all text on yellow backgrounds uses the dark neutral for AA accessibility.
- **Neutral Surface:** A clean, slightly cool off-white that reduces eye strain while maintaining a crisp, modern look.
- **Dark Neutral:** Used for primary text and high-contrast UI elements like bottom sheets or primary buttons to provide a "grounded" feel.

## Typography
This design system utilizes **Plus Jakarta Sans** for its friendly yet precise geometric construction. The typeface features a large x-height which aids readability for younger users.

Hierarchy is established through significant weight shifts. Headlines are bold and slightly tracked-in to appear compact and authoritative. Body text maintains standard tracking and generous line-height to ensure a comfortable reading experience for parents reviewing long reports or student schedules.

## Layout & Spacing
The layout follows a **Fluid-Responsive Grid** model based on an 8px base unit. 

- **Mobile:** 4-column layout with 20px outside margins.
- **Desktop/Tablet:** 12-column centered layout with a max-width of 1200px.

Spacing is designed to feel "airy." Content groups should be separated by `lg` (24px) units, while internal element padding should remain tight at `sm` (12px) or `md` (16px) to maintain a cohesive component feel.

## Elevation & Depth
Depth is created through **Ambient Tonal Layering**. Instead of heavy, dark shadows, this design system utilizes:

1.  **Level 0 (Base):** The neutral background (#F8F9FA).
2.  **Level 1 (Cards):** Pure white (#FFFFFF) with a very soft, diffused shadow: `0px 4px 20px rgba(0, 0, 0, 0.04)`.
3.  **Level 2 (Active/Floating):** White with a more pronounced shadow: `0px 10px 30px rgba(0, 0, 0, 0.08)`.

Transitions between levels should be achieved via surface color shifts (e.g., a "pressed" state might dip from White to a very light Grey) rather than increasing shadow intensity, keeping the UI feeling light and reachable.

## Shapes
The shape language is consistently **Rounded**. This softens the "institutional" nature of a presence-tracking app, making it feel more like a lifestyle tool.

- **Standard Components:** 0.5rem (8px) radius for inputs and small buttons.
- **Containers/Cards:** 1rem (16px) radius for the main content areas.
- **Featured Elements:** 1.5rem (24px) for prominent call-to-action cards or top-level navigation wrappers.

## Components

### Buttons
- **Primary:** Dark Neutral background with White text for high impact, or Primary Green with White text for success-oriented actions.
- **Secondary:** Outlined with a 1px stroke of the Primary color and a transparent background.
- **Tertiary:** Text-only with medium weight for low-priority navigation.

### Cards
Cards are the primary container for student data. They should feature a white background, 1rem corner radius, and the Level 1 soft shadow. Use a 4px vertical accent bar on the left side of the card using the Primary or Secondary color to indicate status (e.g., Green for "Present", Yellow for "Excused").

### Input Fields
Inputs use a subtle grey background with no border in their default state. On focus, they transition to a white background with a 2px Primary Green border. Use clear labels above the field and "label-md" for helper text below.

### Chips & Badges
Small, pill-shaped elements (radius: 100px). Use soft tinted backgrounds (10% opacity of the primary color) with full-opacity text of the same color for high readability without visual noise.

### Navigation
A bottom navigation bar on mobile with clear icons and small text labels. The "Active" state should be indicated by the Primary Green color and a subtle dot indicator below the icon.