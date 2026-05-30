# 🍽️ Restoran - Online Yemek Sipariş Sistemi

Modern ve kullanıcı dostu bir **online restoran sipariş platformu**. PHP ve MySQL ile geliştirilmiş, Docker ile tek komutla çalıştırılabilir tam fonksiyonel bir web uygulaması.

## ✨ Özellikler

### Müşteri Tarafı
- **Kullanıcı Kayıt & Giriş** sistemi
- Restoranları ve yemekleri listeleme
- Detaylı yemek sayfaları (fotoğraf, açıklama, fiyat)
- **Sepet** ve not ekleme özelliği
- **Cüzdan** sistemi (para yükleme)
- Sipariş verme ve sipariş geçmişi
- Kupon kodu desteği
- Restoranlara yorum yapma ve puanlama

### Admin / Yönetici Paneli
- Temel admin paneli (`/admin`)
- Yemek, restoran ve kullanıcı yönetimi
- Siparişleri görüntüleme

### Teknik Özellikler
- **Docker** + **docker-compose** desteği
- Responsive (mobil uyumlu) tasarım
- PDO ile güvenli veritabanı işlemleri
- Bootstrap 5 + SCSS tabanlı modern arayüz

## 🚀 Hızlı Kurulum (Docker)

```bash
git clone https://github.com/mehmet-selcuk-duz/restoran.git
cd restoran

docker-compose up --build
