# Trainers Management System

A Laravel-based application for managing trainers, their sessions, and generating payment reports. This system helps educational institutions manage trainer information, track sessions, and automate payment calculations.

## Features

- Trainer management (personal and bank information)
- Session tracking and management
- Monthly hours calculation
- Automated payment calculation
- Excel report generation
- Bank information management
- Bulk session updates
- Monthly session summaries

## Requirements

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM
- Laravel 10.x requirements

## Installation Guide

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/Trainers-Management.git
   cd Trainers-Management
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   # Copy the example env file
   cp .env.example .env

   # Generate application key
   php artisan key:generate
   ```

5. **Configure Database**
   - Open `.env` file and update database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=trainers_management
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```
   - Create a new MySQL database named `trainers_management`

6. **Run Migrations and Seed Data**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Build Assets**
   ```bash
   npm run dev
   ```

9. **Start the Development Server**
   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000`

## Default Data

After seeding, the system will create:
- Sample trainers with basic information
- Default session schedules
- Initial salary records
- Bank information templates

## Usage Guide

### Managing Trainers

1. **View Trainers**
   - Access the main dashboard to see all trainers
   - Filter trainers by month using the dropdown

2. **Edit Trainer Information**
   - Click "Edit" next to any trainer
   - Update personal information, bank details, or session schedules
   - Changes to session times and duration will apply to all sessions

3. **View Details**
   - Click "View Details" to see comprehensive trainer information
   - View session history and payment calculations

4. **Generate Reports**
   - Use the download button to generate Excel reports
   - Reports include session details and payment calculations

### Session Management

- **Monthly Schedule**
  - Set standard start and end times
  - Define hours per session
  - Update total monthly hours

- **Bulk Updates**
  - Changes to session times apply to all sessions
  - Price per hour updates affect all calculations

### Payment Calculations

The system automatically:
- Calculates total hours per month
- Applies the defined price per hour
- Updates payment totals
- Generates formatted reports

## Troubleshooting

1. **Permission Issues**
   ```bash
   chmod -R 777 storage bootstrap/cache
   ```

2. **Composer Issues**
   ```bash
   composer dump-autoload
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Database Issues**
   ```bash
   php artisan migrate:fresh --seed
   ```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License.
