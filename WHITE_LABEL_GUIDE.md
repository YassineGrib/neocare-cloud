# دليل الـ White Label الشامل لنظام Nextcloud عبر كافة المنصات

هذا الدليل يوضح الأماكن والملفات المسؤولة عن تخصيص الهوية البصرية (Rebranding / White Labeling) لكل منصة من منصات Nextcloud.

---

## 1. تطبيق الأندرويد (Android Client)

* **المسار**: `c:\development\Fanus\naxtcloud\android`
* **الملفات الأساسية**:
  1. **ملف الإعدادات والهوية الرئيسي**: [`app/src/main/res/values/setup.xml`](file:///c:/development/Fanus/naxtcloud/android/app/src/main/res/values/setup.xml)
     - `app_name`: اسم التطبيق المعروض.
     - `account_type`: معرّف الحساب في نظام أندرويد.
     - `authority`: الـ Content Provider Authority (يجب أن يتطابق مع الـ applicationId).
     - `server_url`: عنوان الخادم الافتراضي.
     - `enforce_servers`: إجبار التطبيق على الاتصال بخادم محدد فقط.
     - `color_primary` / `color_accent`: الألوان الرئيسية للهوية.
  2. **معرّف التطبيق (Package Name)**: [`app/build.gradle.kts`](file:///c:/development/Fanus/naxtcloud/android/app/build.gradle.kts)
     - تعديل `applicationId = "com.yourcompany.cloud"`
  3. **الأيقونات والشعارات**:
     - مجلدات `app/src/main/res/mipmap-*` (أيقونات اللانشر).
     - مجلدات `app/src/main/res/drawable-*` (لوجو تسجيل الدخول وSplash screen).

---

## 2. تطبيق سطح المكتب (Desktop Client - Windows / macOS / Linux)

* **المسار**: `c:\development\Fanus\naxtcloud\desktop`
* **الملفات الأساسية**:
  1. **ملف التكوين الرئيسي (CMake)**: [`NEXTCLOUD.cmake`](file:///c:/development/Fanus/naxtcloud/desktop/NEXTCLOUD.cmake)
     - `APPLICATION_NAME`: اسم التطبيق الظاهر.
     - `APPLICATION_SHORTNAME`: الاسم البرمجي المختصر.
     - `APPLICATION_EXECUTABLE`: اسم الملف التنفيذي (.exe).
     - `APPLICATION_DOMAIN`: نطاق الشركة / الخادم.
     - `APPLICATION_VENDOR`: اسم الشركة المطورة.
  2. **الأيقونات والسمات البصرية**:
     - مجلد `theme/`: يحتوي على الأيقونات الملونة (`theme/colored/`)، والبيضاء/السوداء لشريط المهام (Tray Icons).

---

## 3. تطبيق الآيفون والآيباد (iOS Client)

* **المسار**: `c:\development\Fanus\naxtcloud\ios`
* **الملفات الأساسية**:
  1. **خيارات الهوية البرمجية**: [`Brand/NCBrand.swift`](file:///c:/development/Fanus/naxtcloud/ios/Brand/NCBrand.swift)
     - `brand`: اسم التطبيق.
     - `loginBaseUrl`: رابط خادم تسجيل الدخول المباشر.
     - `enforce_servers`: قائمة السيرفرات المسموح بها فقط.
     - `mailSupport`: بريد الدعم الفني.
  2. **الأصول الرسومية**: [`Brand/Custom.xcassets`](file:///c:/development/Fanus/naxtcloud/ios/Brand/Custom.xcassets)
     - يحتوي على `AppIcon` و `logo` و `launchImage`.
  3. **إعدادات الحزمة**: [`Brand/iOSClient.plist`](file:///c:/development/Fanus/naxtcloud/ios/Brand/iOSClient.plist)

---

## 4. خادم الويب (Nextcloud Server)

* **المسار**: `c:\development\Fanus\naxtcloud\server`
* **طريقة التخصيص**:
  - من لوحة تحكم الأدمن (Web UI): `Administration Settings` -> `Theming`.
  - أو برمجياً عبر ملف `config/config.php` بتثبيت تطبيق `theming` وتحديد الشعار، الخلفية، والاسم تلقائياً.
