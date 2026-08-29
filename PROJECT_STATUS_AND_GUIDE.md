# 🚀 مشروع Nextcloud White-Label المتكامل

وثيقة شاملة تحتوي على حالة المشروع، بيانات الخادم، تفاصيل حزمة الأندرويد، ودليل التخصيص عبر كافة المنصات.

---

## 1. 🌐 خادم Nextcloud المحلي (Nextcloud Server)

تم تثبيت وتشغيل الخادم المحلي بنجاح عبر **Docker Compose**.

### 🔑 بيانات الدخول والاتصال:
* **رابط الواجهة (Web UI)**: [http://localhost:8080](http://localhost:8080)
* **اسم المستخدم (Admin)**: `admin`
* **كلمة المرور (Password)**: `admin_password`
* **رابط الاتصال من محاكي أندرويد (Emulator)**: `http://10.0.2.2:8080`

### 🐳 حاويات Docker النشطة:
| الحاوية (Container) | الخدمة | المنفذ (Port) | الحالة |
| :--- | :--- | :--- | :--- |
| **`nextcloud-app`** | Nextcloud Hub (Apache + PHP 8.5) | `8080 -> 80` | ✅ **Up & Running** |
| **`nextcloud-db`** | MariaDB 10.11 | `3306` | ✅ **Up & Running** |
| **`nextcloud-redis`** | Redis Cache & File Locking | `6379` | ✅ **Up & Running** |

### 🛠️ أوامر إدارة السيرفر:
```powershell
# تشغيل الخادم في الخلفية
cd c:\development\Fanus\naxtcloud\server
docker compose up -d

# إيقاف الخادم
docker compose stop

# عرض السجلات (Logs)
docker logs -f nextcloud-app
```

---

## 2. 📱 تطبيق أندرويد (Android Mobile App — Neocare Clinic)

تم تخصيص الهوية البصرية (White-Label) وتثبيت خط **IBM Plex Sans Arabic** وبناء ملف الـ **APK** بنجاح.

### 📦 تفاصيل حزمة الـ APK المُنشأة:
* **اسم التطبيق (App Label)**: `Neocare Clinic`
* **معرّف الحزمة (Package ID)**: `com.neocare.clinic`
* **مسار الملف المستخرج**: [`c:\development\Fanus\naxtcloud\build_output\android\Neocare-Android-Debug.apk`](file:///c:/development/Fanus/naxtcloud/build_output/android/Neocare-Android-Debug.apk)
* **المسار الأصلي من Gradle**: [`c:\development\Fanus\naxtcloud\android\app\build\outputs\apk\generic\debug\app-generic-debug.apk`](file:///c:/development/Fanus/naxtcloud/android/app/build/outputs/apk/generic/debug/app-generic-debug.apk)
* **الحجم**: **107.6 ميجابايت** (`112,830,584 bytes`)
* **النسخة (Flavor)**: `genericDebug`
* **الخطوط المدمجة**: عائلة `IBM Plex Sans Arabic` الرسمية بجميع أوزانها
* **الألوان المطبقة**: Crimson Red (`#7c3a3d`), Dark Maroon (`#290d0d`), Gold (`#cbab58`)
* **بيئة البناء**: OpenJDK 21.0.12.1 LTS (`C:\src\openjdk21`)

### 🔨 أمر إعادة بناء الـ APK:
```powershell
cd c:\development\Fanus\naxtcloud\android
$env:JAVA_HOME = "C:\src\openjdk21"
$env:Path = "C:\src\openjdk21\bin;" + $env:Path
.\gradlew.bat assembleGenericDebug
```

---

## 3. 🎨 دليل تخصيص الـ White-Label عبر كافة المنصات

### أ) تطبيق أندرويد (Android Client):
* **المسار**: `c:\development\Fanus\naxtcloud\android`
* **الملفات الرئيسية للتخصيص**:
  1. **ملف الإعدادات والألوان الأساسي**: [`app/src/main/res/values/setup.xml`](file:///c:/development/Fanus/naxtcloud/android/app/src/main/res/values/setup.xml)
     - `app_name`: اسم التطبيق المعروض.
     - `account_type`: معرّف الحساب في النظام (مثل `com.company.cloud`).
     - `authority`: الـ Content Provider Authority (مطابق للـ Application ID).
     - `server_url`: عنوان السيرفر الافتراضي (مثل `http://10.0.2.2:8080` أو رابط الدومين).
     - `enforce_servers`: إجبار التطبيق على الاتصال بالسيرفر المحدد فقط.
     - `color_primary` / `color_accent`: ألوان الهوية البصرية.
  2. **معرّف التطبيق (Application ID)**: [`app/build.gradle.kts`](file:///c:/development/Fanus/naxtcloud/android/app/build.gradle.kts)
     - تغيير `applicationId = "com.company.cloud"`
  3. **الأيقونات والشعارات**:
     - أيقونات التطبيق: `app/src/main/res/mipmap-*`
     - شعار تسجيل الدخول وSplash: `app/src/main/res/drawable-*`

---

### ب) تطبيق سطح المكتب (Desktop Client - Windows / macOS / Linux):
* **المسار**: `c:\development\Fanus\naxtcloud\desktop`
* **الملفات الرئيسية للتخصيص**:
  1. **ملف التكوين العام (CMake)**: [`NEXTCLOUD.cmake`](file:///c:/development/Fanus/naxtcloud/desktop/NEXTCLOUD.cmake)
     - `APPLICATION_NAME`: اسم البرنامج الظاهر.
     - `APPLICATION_SHORTNAME`: الاسم البرمجي المختصر.
     - `APPLICATION_EXECUTABLE`: اسم الملف التنفيذي (.exe).
     - `APPLICATION_DOMAIN`: رابط خادم الشركة.
     - `APPLICATION_VENDOR`: اسم الشركة المطورة.
  2. **الأيقونات والهوية**:
     - مجلد `theme/`: يحتوي على الأيقونات الملونة وأيقونات شريط المهام (Tray Icons).

---

### ج) تطبيق الآيفون والآيباد (iOS Client):
* **المسار**: `c:\development\Fanus\naxtcloud\ios`
* **الملفات الرئيسية للتخصيص**:
  1. **إعدادات الهوية البرمجية**: [`Brand/NCBrand.swift`](file:///c:/development/Fanus/naxtcloud/ios/Brand/NCBrand.swift)
     - `brand`: اسم التطبيق.
     - `loginBaseUrl`: رابط خادم الدخول المباشر.
     - `enforce_servers`: تحديد الخوادم المسموح بها فقط.
     - `mailSupport`: بريد الدعم الفني.
  2. **الأصول الرسومية (Assets)**: [`Brand/Custom.xcassets`](file:///c:/development/Fanus/naxtcloud/ios/Brand/Custom.xcassets)
     - أيقونات `AppIcon`، والشعار `logo`، وخلفية البداية `launchImage`.

---

### د) خادم الويب والواجهة (Web UI Theming):
* **المسار**: `c:\development\Fanus\naxtcloud\server`
* **طريقة التخصيص**:
  1. الدخول بحساب الأدمن: [http://localhost:8080](http://localhost:8080)
  2. الانتقال إلى **Administration Settings** -> **Theming**.
  3. تحديد: اسم المنصة، الشعار (Logo)، الألوان الأساسية (Color Role)، وصورة الخلفية لشاشة تسجيل الدخول.
