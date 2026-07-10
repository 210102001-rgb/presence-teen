---
name: Academic Excellence Portal
colors:
  surface: '#f6fafe'
  surface-dim: '#d6dade'
  surface-bright: '#f6fafe'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f0f4f8'
  surface-container: '#eaeef2'
  surface-container-high: '#e4e9ed'
  surface-container-highest: '#dfe3e7'
  on-surface: '#171c1f'
  on-surface-variant: '#3f493f'
  inverse-surface: '#2c3134'
  inverse-on-surface: '#edf1f5'
  outline: '#6f7a6e'
  outline-variant: '#becabc'
  surface-tint: '#006d34'
  primary: '#005f2d'
  on-primary: '#ffffff'
  primary-container: '#0e7a3d'
  on-primary-container: '#a5ffb7'
  inverse-primary: '#7bda92'
  secondary: '#5c5f61'
  on-secondary: '#ffffff'
  secondary-container: '#e0e3e5'
  on-secondary-container: '#626567'
  tertiary: '#495362'
  on-tertiary: '#ffffff'
  tertiary-container: '#616b7b'
  on-tertiary-container: '#e2ecff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#97f7ac'
  primary-fixed-dim: '#7bda92'
  on-primary-fixed: '#00210b'
  on-primary-fixed-variant: '#005226'
  secondary-fixed: '#e0e3e5'
  secondary-fixed-dim: '#c4c7c9'
  on-secondary-fixed: '#191c1e'
  on-secondary-fixed-variant: '#444749'
  tertiary-fixed: '#d9e3f6'
  tertiary-fixed-dim: '#bdc7d9'
  on-tertiary-fixed: '#121c2a'
  on-tertiary-fixed-variant: '#3d4756'
  background: '#f6fafe'
  on-background: '#171c1f'
  surface-variant: '#dfe3e7'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '700'
    lineHeight: '1.2'
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '600'
    lineHeight: '1.3'
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: '1.3'
  title-md:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: '1.4'
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: '1.5'
  label-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: '1'
    letterSpacing: 0.05em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  xs: 4px
  sm: 8px
  md: 16px
  lg: 24px
  xl: 32px
  2xl: 48px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 40px
  max-width: 1440px
---

## Brand & Style
The design system is engineered for a premium educational environment, specifically tailored for high-school parental engagement. The brand personality is **authoritative yet accessible**, bridging the gap between formal institutional communication and modern SaaS efficiency.

The visual style is a hybrid of **Minimalism** and **Corporate Modernism**. It prioritizes high-density information clarity while maintaining an "academic premium" feel through generous whitespace and a sophisticated execution of the school's heritage colors. Inspired by high-performance tools like Google Analytics and Notion, the UI avoids unnecessary decoration, using subtle depth and precise typography to guide the user's focus toward student performance data and institutional insights.

## Colors
This design system utilizes a structured palette centered around "School Green" (#0E7A3D). 

- **Primary:** Used for brand identity, primary actions, and active states.
- **Surface Scale:** A range of ultra-light grays (F8FAFC to F1F5F9) provides soft nesting for dashboard components without the harshness of pure white.
- **Text & UI:** Dark Charcoal (#1F2937) is used for high-contrast typography, ensuring maximum readability for academic reports.
- **Semantic Colors:** Status colors are calibrated for high visibility on light backgrounds, used for attendance indicators, grade alerts, and system feedback.

## Typography
The system relies on **Inter** to deliver a systematic, utilitarian aesthetic that remains readable across data-heavy tables and analytical charts. 

- **Headlines:** Utilize tighter letter-spacing and semi-bold weights to establish a clear information hierarchy.
- **Body Text:** Set with generous line-heights to facilitate long-form reading of school announcements and academic feedback.
- **Labels:** Used for chart legends and metadata, often employing an uppercase style for distinction.

## Layout & Spacing
The layout follows a **Fluid Grid** model with a max-width constraint for desktop viewing to maintain readability.

- **Desktop (12 Columns):** 24px gutters with 40px outer margins. Content is organized into modular cards.
- **Tablet (8 Columns):** 16px gutters. Sidebars collapse into a drawer or a narrow icon-only rail.
- **Mobile (4 Columns):** 16px margins. Layout stacks vertically, and dashboard cards become full-width.

Spacing follows a linear 4px/8px scale. Padding within dashboard cards should consistently use the `lg` (24px) token to ensure the "large white space" design principle is maintained.

## Elevation & Depth
Elevation is achieved through **Ambient Shadows** rather than harsh borders, creating a layered, "soft-stack" appearance.

- **Level 0 (Background):** #F8FAFC.
- **Level 1 (Cards):** Pure white background with a subtle shadow: `0 1px 3px rgba(0,0,0,0.05), 0 4px 6px rgba(0,0,0,0.02)`.
- **Level 2 (Modals/Popovers):** Higher contrast shadow to indicate interaction: `0 10px 15px rgba(0,0,0,0.1)`.

Charts and AI components use **Tonal Layers** (e.g., a slightly darker gray background) to differentiate information zones without increasing the shadow depth.

## Shapes
The shape language is defined by **Softened Geometry**. 

A standard border-radius of **12px** is applied to all primary containers and cards, striking a balance between the friendly nature of educational software and the professional rigor of a SaaS platform. Smaller elements like buttons and input fields follow this 12px rule, while "pills" (status tags) use a fully rounded radius.

## Components
- **Dashboard Cards:** The primary container. Must have 24px internal padding, 12px corner radius, and Level 1 elevation.
- **AI-Insight Components:** Distinguished by a subtle gradient border using the Primary Green and Info Blue, or a light tinted background (#F0FDF4). Include a "sparkle" icon to denote AI-generated content.
- **Charts:** Use a 2px stroke width for line charts. Color sequence: Primary Green, Info Blue, Warning Amber. Use Inter Label-sm for all axis text.
- **Buttons:** 
  - *Primary:* Solid #0E7A3D with white text. 
  - *Secondary:* Ghost style with #0E7A3D border and text.
- **Input Fields:** 1px border (#E2E8F0), 12px radius, with 12px vertical padding. Focus state uses a 2px Primary Green ring.
- **Status Chips:** High-radius (pill) shapes with low-opacity background tints of the status color and high-opacity text (e.g., Success: #DCFCE7 background with #166534 text).