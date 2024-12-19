pipeline {
    agent any

    environment {
        COMPOSE_FILE = "docker-compose.yml" // File docker-compose Anda
        WEB_CONTAINER = "tubeskomputasiawan-web-1" // Nama container aplikasi PHP
        DB_CONTAINER = "tubeskomputasiawan-db-1"  // Nama container MySQL
        DB_USER = "root" // User database
        DB_PASSWORD = "123456" // Password database
        DB_NAME = "komputasi_awan" // Nama database
    }

    stages {
        stage('Checkout Code') {
            steps {
                echo 'Checking out source code...'
                checkout scm
            }
        }

        stage('Build and Start Services') {
            steps {
                echo 'Building and starting services with Docker Compose...'
                script {
                    // Hentikan jika container sedang berjalan
                    bat 'docker-compose down || true'
                    // Build ulang dan jalankan container
                    bat 'docker-compose up -d --build'
                }
            }
        }

        stage('Run Application Tests') {
            steps {
                echo 'Testing if the application is running...'
                script {
                    // Tunggu container siap
                    bat 'powershell -Command "Start-Sleep -Seconds 10"'

                    // Tes apakah endpoint web (port 8082) dapat diakses
                    bat 'curl -f http://localhost:8082 || exit 1'
                }
            }
        }

        stage('Database Check') {
            steps {
                echo 'Verifying database initialization...'
                script {
                    // Cek koneksi ke database dan tabel
                    bat """
                    docker exec ${DB_CONTAINER} mysql -u${DB_USER} -p${DB_PASSWORD} -e "USE ${DB_NAME}; batOW TABLES;" || exit 1
                    """
                }
            }
        }

        stage('Cleanup') {
            steps {
                echo 'Cleaning up Docker Compose services...'
                bat 'docker-compose down -v' // Hentikan container dan hapus volume
            }
        }
    }

    post {
        always {
            echo 'Pipeline completed.'
            script {
                // Pastikan layanan dihentikan
                bat 'docker-compose down -v || true'
            }
        }
        failure {
            echo 'Pipeline failed.'
        }
    }
}
