## Getting Started

First, setup the application:

```bash
composer install
```
```bash
npm install
```

Create a `.env` file in the root folder of the project and copy the contents from the `.env.example` file.

In your `.env` file, add your Github's personal access token

```bash
GITHUB_PERSONAL_TOKEN=your_personal_aGITHUB_PERSONAL_TOKEN=your_personal_access_token
```

Generate your `APP_KEY`

```bash
php artisan key:generate
```

Then, run the development server:

```bash
composer run dev
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) with your browser to see the result.