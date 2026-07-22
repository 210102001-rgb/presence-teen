# Presence Teen - Tech Stack Documentation

Complete overview of all technologies, frameworks, and libraries used in the project.

## 🎯 Quick Summary

```
Backend:        Laravel 13 (PHP 8.3)
Frontend:       Blade Templates + Alpine.js + Tailwind CSS 3
Database:       MySQL 8.0+
Build Tool:     Vite 8
Auth:           Laravel Breeze + Custom Middleware
Real-time:      Livewire 4
PDF Handling:   smalot/pdfparser
Word Docs:      phpoffice/phpword
QR Codes:       simplesoftwareio/simple-qrcode
AI Integration: Anthropic Claude API
Testing:        PHPUnit 12
Code Quality:   Laravel Pint
```

---

## 📚 Detailed Tech Stack

### 🔵 Backend Technologies

#### PHP & Framework
- **PHP 8.3**
  - Latest PHP version
  - Type safety
  - Named arguments
  - Enums
  - Attributes (used throughout project)

- **Laravel 13.8** (Latest)
  - Web framework
  - Routing
  - Middleware
  - ORM (Eloquent)
  - Authentication
  - Authorization (Gates & Policies)
  - Migrations
  - Seeding
  - Queue system
  - Cache system
  - Validation
  - Error handling

#### Key Laravel Components Used
```
app/
├── Http/
│   ├── Controllers/       (13 controllers)
│   ├── Middleware/        (RoleMiddleware)
│   └── Requests/          (Form validation)
├── Models/                (12 models with relationships)
├── Notifications/         (Email notifications)
├── Providers/             (AppServiceProvider, auth config)
├── Livewire/              (Interactive components)
└── Console/               (Artisan commands)

database/
├── migrations/            (25+ migration files)
├── seeders/               (DatabaseSeeder)
└── factories/             (UserFactory)

resources/
├── views/                 (40+ Blade templates)
├── js/                    (Alpine.js)
├── css/                   (Tailwind CSS)
└── lang/                  (i18n - Indonesian)
```

### 🟢 Frontend Technologies

#### HTML & Templating
- **Blade** (Laravel templating engine)
  - Component system (`x-app-layout`, `x-guest-layout`)
  - Template inheritance
  - Directives (`@if`, `@foreach`, `@json`, etc.)
  - Slots for dynamic content

#### JavaScript Framework
- **Alpine.js 3.4.2**
  - Lightweight reactive framework
  - DOM manipulation
  - Form handling
  - Real-time validation
  - Modal dialogs
  - Dropdown menus
  - Toast notifications
  - File preview display
  - Dynamic form updates

#### CSS Framework
- **Tailwind CSS 3.1.0**
  - Utility-first CSS
  - Custom design system (Material Design 3)
  - Responsive design
  - Color tokens
  - Custom shadows
  - Typography
  - Layout utilities

#### Tailwind Plugins
- **@tailwindcss/forms** (0.5.2)
  - Better form styling
  - Input, textarea, select styles
  - Checkbox & radio styling

#### Font
- **Inter** (from Google Fonts)
  - Primary font family
  - Clean, modern typography

### 🟠 Build & Development Tools

#### Frontend Build
- **Vite 8.0.0**
  - Module bundler
  - Dev server with HMR
  - Asset compilation
  - Fast build times
  - ES module support

- **laravel-vite-plugin 3.1**
  - Integrates Vite with Laravel
  - Asset versioning
  - Dev/production builds

#### CSS Processing
- **Tailwind CSS** (included above)
- **PostCSS 8.4.31**
  - CSS transformations
  - Autoprefixer
  - Tailwind processing

- **Autoprefixer 10.4.2**
  - Browser vendor prefixes
  - Cross-browser compatibility

#### Development Dependencies
```json
{
  "alpinejs": "^3.4.2",
  "@tailwindcss/forms": "^0.5.2",
  "tailwindcss": "^3.1.0",
  "postcss": "^8.4.31",
  "autoprefixer": "^10.4.2",
  "vite": "^8.0.0",
  "laravel-vite-plugin": "^3.1",
  "concurrently": "^9.0.1"
}
```

### 🔴 Database

#### MySQL 8.0+
- **Primary Database**
- **Tables**: 20+ tables
- **Relationships**: Complex relational model
- **Migrations**: Version controlled schema
- **Seeders**: Demo data generation

**Key Models & Tables:**
```
users                   (All user roles)
kelas                  (Classes)
siswa_kelas            (Class enrollment)
presensi               (Attendance records)
sesi_presensi          (Attendance sessions)
tugas                  (Tasks/assignments)
pengumpulan_tugas      (Task submissions)
materi                 (Learning materials)
jadwal_kelas           (Class schedules)
orang_tua_siswas       (Parent-student links)
laporan_ais            (AI analysis reports)
pengumuman             (Announcements)
failed_jobs            (Queue failures)
cache                  (Cache storage)
sessions               (Session storage)
```

#### Alternative Storage (for testing)
- **SQLite** (`:memory:` for tests)
- Test configuration in `phpunit.xml`

### 🟣 Authentication & Authorization

#### Authentication
- **Laravel Breeze**
  - User registration
  - Login/logout
  - Password reset
  - Email verification
  - Session management

#### Authorization
- **Custom Role Middleware**
  - Routes: `role:guru`, `role:siswa`, `role:orang_tua`, `role:super_admin`
  - Gate: `isAdmin` for super admin checks
  - Policy: `UserPolicy` for account management

#### Roles Supported
```
1. siswa          (Student)
2. guru           (Teacher)
3. orang_tua      (Parent)
4. super_admin    (Administrator)
```

### 🟡 Real-time Components

#### Livewire 4.3
- **QR Presensi Component**
  - Live QR code generation
  - Real-time session management
  - Alpine.js integration

- **Chat AI Component**
  - Interactive chat interface
  - Real-time AI responses

### 🔵 Data Processing Libraries

#### PDF Handling
- **smalot/pdfparser**
  - Extract text from PDF files
  - Material summarization
  - Used in `MateriController`

#### Word Document Handling
- **phpoffice/phpword**
  - Extract text from DOCX files
  - Document parsing
  - Material processing

#### QR Code Generation
- **simplesoftwareio/simple-qrcode 4.2**
  - Generate QR codes
  - Display as image
  - Used in attendance system
  - Mobile scanning support

### 🤖 AI Integration

#### Anthropic Claude API
- **Direct HTTP Integration** (no SDK)
- **Model**: Claude 3.5 Sonnet (latest)
- **API Version**: 2023-06-01
- **Use Cases**:
  - Material summarization
  - Weekly attendance analysis
  - Student performance insights
  - Automated report generation

**Configuration:**
```env
AI_API_BASE_URL=https://api.anthropic.com/v1
AI_API_KEY=[your-api-key]
AI_MODEL=claude-3-5-sonnet-20241022
AI_VERSION=2023-06-01
```

### 🧪 Testing & Quality Assurance

#### Testing Framework
- **PHPUnit 12.5.12**
  - Unit tests
  - Feature tests
  - Database testing
  - Test database: SQLite `:memory:`

#### Code Quality
- **Laravel Pint 1.27**
  - Code formatter
  - Follows PSR-12 standard
  - Laravel code style
  - Auto-fixes issues

#### Development Tools
- **Faker 1.23** (fakerphp)
  - Generates fake data for testing
  - User factory generation

- **Mockery 1.6**
  - Mock object library
  - Dependency mocking

- **Collision 8.6**
  - Better error display
  - Improved exception handling

#### Development Utilities
- **Laravel Tinker 3.0**
  - Interactive REPL
  - Database queries
  - Testing code snippets

- **Laravel Pail 1.2.5**
  - Real-time log viewing
  - Terminal log streaming

- **Laravel Pao 1.0.6**
  - Performance monitoring
  - Debug utilities

---

## 🏗️ Architecture & Design Patterns

### Design Patterns Used
```
MVC Pattern:
  - Models       (Eloquent ORM)
  - Views        (Blade templates)
  - Controllers  (13 controller classes)

Repository Pattern:
  - Model scopes for queries
  - Relationship queries

Factory Pattern:
  - Database factories
  - Model factories

Observer Pattern:
  - Model events
  - Database listeners

Middleware Pattern:
  - Role middleware
  - Auth middleware
  - CSRF protection
```

### Code Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/              (6 auth controllers)
│   │   ├── AccountController  (Admin CRUD)
│   │   ├── DashboardController
│   │   ├── PresensiController
│   │   ├── TugasController
│   │   ├── MateriController
│   │   ├── JadwalController
│   │   ├── KelasController
│   │   ├── LaporanController
│   │   └── ...
│   ├── Middleware/
│   │   └── RoleMiddleware
│   └── Requests/
│       └── Validation classes
├── Models/
│   ├── User
│   ├── Kelas
│   ├── Presensi
│   ├── Tugas
│   ├── Materi
│   └── ...
├── Livewire/
│   ├── QrPresensi
│   └── ChatAi
├── Console/
│   └── Commands/
│       └── AnalisisKehadiranCommand
└── Providers/
    └── AppServiceProvider
```

---

## 📦 Dependencies Summary

### Production Dependencies
```
PHP ^8.3
Laravel ^13.8
Livewire ^4.3
smalot/pdfparser
phpoffice/phpword
simplesoftwareio/simple-qrcode ^4.2
```

### Development Dependencies
```
PHP ^8.3
Laravel Breeze ^2.4
Laravel Pail ^1.2.5
Laravel Pao ^1.0.6
Laravel Pint ^1.27
PHPUnit ^12.5.12
Faker ^1.23
Mockery ^1.6
Collision ^8.6
```

### Frontend Dependencies
```
Vite ^8.0.0
laravel-vite-plugin ^3.1
Tailwind CSS ^3.1.0
@tailwindcss/forms ^0.5.2
Alpine.js ^3.4.2
PostCSS ^8.4.31
Autoprefixer ^10.4.2
```

---

## 🔄 Deployment Technologies

### Server Requirements
- **PHP 8.3+**
- **MySQL 8.0+**
- **Apache 2.4+** (with mod_rewrite)
- **Composer 2.0+**
- **npm/Node.js** (optional, for asset building)

### Hosting Platform
- **Rumahweb** (Indonesian shared hosting)
- **cPanel** (Server management)
- **AutoSSL** (SSL certificates)

### Deployment Tools Used
- **Composer** (PHP dependency management)
- **npm** (JavaScript dependency management)
- **FTP/SFTP** (File transfer)
- **SSH** (Remote server access)
- **Git** (Version control)

---

## 📊 Language & Localization

### Languages Supported
- **English** (Fallback)
- **Indonesian** (Primary UI language - Bahasa Indonesia)

### Translation Files
```
resources/lang/id/
└── messages.php     (300+ translation strings)
```

---

## 🔧 Configuration Files

### Key Configuration Files
```
config/
├── app.php              (App name, timezone, locale)
├── auth.php             (Authentication config)
├── cache.php            (Cache driver)
├── database.php         (Database connection)
├── filesystems.php      (File storage)
├── livewire.php         (Livewire config)
├── logging.php          (Log channels)
├── mail.php             (Mail configuration)
├── queue.php            (Queue driver)
├── session.php          (Session driver)
└── services.php         (Third-party services)
```

### Environment Configuration
```
.env                    (Local development)
.env.example            (Template)
.env.production.example (Production template)
phpunit.xml             (Test configuration)
```

---

## 🎨 Design System

### Color Palette (Material Design 3)
```
Primary:          #005f2d (School Green)
Secondary:        #5c5f61 (Gray)
Tertiary:         #495362 (Blue-Gray)
Error:            #ba1a1a (Red)
Surface:          #f6fafe (Light)
On-Surface:       #171c1f (Dark Text)
```

### Typography
- **Font**: Inter (Google Fonts)
- **Font Sizes**: Tailwind defaults + custom
- **Line Heights**: Optimized for readability

### Component System
```
Components:
├── AppLayout              (Main application layout)
├── GuestLayout            (Auth layout)
├── MobileBottomNav        (Mobile navigation)
└── [Other Blade components]

Livewire Components:
├── QrPresensi            (QR generation)
└── ChatAi                (AI chat)
```

---

## 📈 Performance Considerations

### Optimization Techniques Used
- **Query Optimization**: Eager loading with `with()`
- **Caching**: File cache driver with configuration caching
- **Database Indexing**: Foreign keys indexed
- **Asset Minification**: Vite production builds
- **Lazy Loading**: Images with loading="lazy"
- **CSS/JS Splitting**: Vite code splitting

### Performance Tools
- **Laravel Pao**: Performance monitoring
- **Query monitoring**: In Tinker
- **Pail**: Real-time log monitoring

---

## 🔐 Security Features

### Built-in Security
- **CSRF Protection**: Token validation
- **SQL Injection Prevention**: Parameterized queries
- **XSS Prevention**: Blade escaping
- **Password Hashing**: bcrypt (rounds: 12)
- **Authentication**: Laravel Breeze
- **Authorization**: Role-based middleware
- **HTTPS/SSL**: AutoSSL certificates

### Security Packages
- Laravel's built-in security features
- No additional security libraries needed
- OWASP compliance

---

## 📚 Documentation & Tools

### Development Commands
```bash
composer setup           # Install & setup
composer dev             # Run dev server + queue + logs + vite
composer test            # Run tests
./vendor/bin/pint        # Format code
php artisan tinker       # REPL shell
php artisan pail         # Log monitoring
```

### Included Commands
```
php artisan migrate      # Run migrations
php artisan db:seed      # Seed database
php artisan storage:link # Create storage symlink
php artisan optimize     # Optimize for production
php artisan queue:listen # Process queue jobs
```

---

## 🌐 External APIs & Services

### AI Services
- **Anthropic Claude API**
  - Endpoint: https://api.anthropic.com/v1
  - Model: Claude 3.5 Sonnet
  - Use: Material summarization, attendance analysis

### Fonts
- **Google Fonts - Inter**
  - CDN-hosted font
  - Used in UI/UX

### CDN Resources (Optional)
- **Material Symbols** (Google Icons)
- **Alpine.js** (from CDN in guest layout)
- **html5-qrcode** (QR scanner)

---

## 🔄 Version Information

### Current Versions
```
PHP:              8.3+
Laravel:          13.8
Livewire:         4.3
Tailwind CSS:     3.1.0
Alpine.js:        3.4.2
Vite:             8.0.0
PHPUnit:          12.5.12
MySQL:            8.0+
Node.js:          18+ (for npm)
```

### Version Support
- **PHP 8.3**: Minimum supported version
- **Laravel 13**: Latest stable version
- **Tailwind 3**: Stable version (v4 available but not used)
- **Alpine.js 3**: Latest stable

---

## 🎓 Learning Path

To understand this project, you should be familiar with:

1. **PHP 8.3** - Object-oriented programming, attributes
2. **Laravel 13** - Routing, controllers, models, middleware
3. **Blade** - Template syntax, components, directives
4. **Alpine.js** - Reactive DOM interactions
5. **Tailwind CSS** - Utility-first CSS framework
6. **MySQL** - Relational database design
7. **REST APIs** - HTTP requests, JSON
8. **Git** - Version control basics

---

## 📝 Summary Table

| Layer | Technology | Version | Purpose |
|-------|-----------|---------|---------|
| **Backend** | Laravel | 13.8 | Web framework |
| **Language** | PHP | 8.3+ | Server-side |
| **Frontend** | Alpine.js | 3.4 | Interactivity |
| **Styling** | Tailwind CSS | 3.1 | UI design |
| **Database** | MySQL | 8.0+ | Data storage |
| **Build Tool** | Vite | 8.0 | Asset bundling |
| **Auth** | Breeze | 2.4 | Authentication |
| **Real-time** | Livewire | 4.3 | Live components |
| **AI** | Claude API | Latest | AI features |
| **Testing** | PHPUnit | 12.5 | Unit tests |
| **Hosting** | Rumahweb | - | Web hosting |
| **Server** | Apache | 2.4+ | Web server |

---

## 🎯 Tech Stack Highlights

✅ **Modern**: Uses latest versions of all frameworks
✅ **Secure**: Built-in security best practices
✅ **Scalable**: Proper architecture for growth
✅ **Testable**: Includes testing framework
✅ **Maintainable**: Clean code with patterns
✅ **Fast**: Optimized for performance
✅ **Production-Ready**: Deployment guides included

---

## 🚀 Ready to Deploy?

With this comprehensive tech stack, your Presence Teen application is:

- ✅ Built on proven, stable technologies
- ✅ Secured with industry best practices
- ✅ Optimized for production environments
- ✅ Ready for growth and scaling
- ✅ Easy to maintain and update

See **DEPLOYMENT_INDEX.md** for deployment guides!

---

**Last Updated**: July 20, 2026
**Status**: Production Ready ✅
