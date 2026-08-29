# نقاط التخصيص (White-Label) لكل منصة

## iOS — `clients/ios/Brand/NCBrand.swift`
- ملف Swift واحد يحتوي على كل ثوابت العلامة التجارية: اسم التطبيق، الألوان، الروابط الافتراضية، الأيقونات.
- الأيقونة: `AppIcon.icon` في جذر المستودع (asset catalog).
- يحتاج أيضاً تعديل Bundle ID + Signing في Xcode project قبل الأرشفة.

## Android — `clients/android/app/build.gradle.kts` + `utils/theme/`
- لا يوجد مجلد "Brand" مخصص؛ التخصيص يتم عبر:
  - `app/build.gradle.kts` → applicationId, versionName, resValue للاسم
  - `app/src/main/java/.../utils/theme/` → ServerThemeImpl, MaterialSchemesProvider (الألوان تُقرأ من خادم Nextcloud نفسه عبر capabilities API، بالإضافة لألوان افتراضية في الكود)
  - الأيقونة: `app/src/main/res/mipmap-*/ic_launcher*`
- **ملاحظة مهمة:** Nextcloud Android يدعم تلقائياً قراءة ألوان الثيم من الخادم (theming app من جهة السيرفر) — قد يقلل هذا حاجتنا لتعديل الكود يدوياً للألوان.

## Desktop (Windows/macOS) — `clients/desktop/config.h.in` + `NEXTCLOUD.cmake`
- `NEXTCLOUD.cmake` يحتوي متغيرات CMake: APPLICATION_NAME, APPLICATION_EXECUTABLE, APPLICATION_ICON_NAME, ألخ.
- `config.h.in` يُولَّد وقت البناء من هذه المتغيرات.
- التعبئة: `NextcloudCPack.cmake` (Windows installer), `admin/osx/*.cmake` (macOS pkg/dmg).

## الويب
- Nextcloud "web" ليس تطبيق عميل منفصل — هو واجهة خادم Nextcloud نفسه (server repo، PHP). التخصيص يتم عبر "theming app" المدمجة في السيرفر (اسم، شعار، ألوان تُضبط من لوحة تحكم الأدمن) — لا حاجة لكود إضافي على الأغلب، فقط إعداد من إدارة الخادم. يحتاج توضيح: هل العميل يريد فقط ضبط theming app على خادمه، أم تخصيص كود إضافي؟

## الخطوة التالية (بعد استلام العناصر من العميل - البند 3)
1. إعداد Bundle ID / Package ID / Application ID فريد للعميل على كل منصة
2. تعديل NCBrand.swift (iOS)، build.gradle.kts + الأيقونات (Android)، NEXTCLOUD.cmake (Desktop)
3. ربط الكل برابط خادم Nextcloud الخاص بالعميل كـ default server URL
4. اختبار البناء على كل منصة قبل التوقيع النهائي
