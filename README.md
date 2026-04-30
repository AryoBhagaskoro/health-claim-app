Dear Bapak/Ibu

Berikut saya lampirkan langkah-langkah dan hal-hal yang perlu diketahui untuk menjalankan Program yang sudah saya bangun,, Terimakasih

Health Claim Management System TUGURE
1. Fitur
- CRUD Members
- CRUD Benefit Plans
- Submit Claim
- Auto calculation:
  - Remaining Limit
  - Approved Amount
  - Excess Amount
- Dashboard & Reports (Chart.js)
---

2. Business Logic
Remaining Limit = Annual Limit - Total Previous Approved
Approved = min(Claim Amount, Remaining Limit)
Excess = Claim Amount - Approved

---

3. Backend
- Laravel 12
- PostgreSQL

4. Frontend
- Vue 3
- Tailwind CSS
- Chart.js
---

5. Installation
a. Clone project
git clone https://github.com/AryoBhagaskoro/health-claim-app.git
cd health-claim-app

b. Install backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

c. Install frontend
npm install
npm run dev
---

6. User Role
- **Admin**
  - Full access (CRUD)
