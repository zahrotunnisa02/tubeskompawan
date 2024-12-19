pipeline {
    agent any

    environment {
        COMPOSE_FILE = "docker-compose.yml"
        MYSQL_CONTAINER = "project_db_1" // Sesuaikan nama container db Anda sesuai prefiks Compose
        WEB_CONTAINER = "project_web_1" // Sesuaikan nama container web Anda sesuai prefiks Compose
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
                sh 'docker-compose down || true' // Hentikan layanan jika sebelumnya sudah berjalan
                sh 'docker-compose up -d --build' // Build ulang dan jalankan semua layanan secara background
            }
        }

        stage('Run Tests') {
            steps {
                echo 'Running application tests...'
                script {
                    // Tes menggunakan curl untuk memeriksa respons endpoint
                    sh 'sleep 10' // Beri waktu untuk memastikan semua container siap
                    sh 'curl -f http://localhost:8082 || exit 1' // Uji aplikasi berjalan di port 8082
                }
            }
        }

        stage('Linting and Code Quality Check') {
            steps {
                echo 'Performing linting and code quality checks...'
                // Tambahkan alat linting atau tools code quality yang relevan di sini
                // Contoh: menjalankan PHP lint
                sh 'docker exec ${WEB_CONTAINER} php -l /var/www/html/index.php'
            }
        }

        stage('Database Check') {
            steps {
                echo 'Verifying database initialization...'
                script {
                    sh """
                    docker exec ${MYSQL_CONTAINER} mysql -uroot -p123456 -e "USE komputasi_awan; SHOW TABLES;" || exit 1
                    """
                }
            }
        }

        stage('Cleanup') {
            steps {
                echo 'Cleaning up Docker Compose services...'
                sh 'docker-compose down -v' // Hentikan layanan dan hapus volume untuk membersihkan data
            }
        }
    }

    post {
        always {
            echo 'Pipeline finished, ensuring cleanup...'
            script {
                // Pastikan semua layanan dihentikan jika ada error
                sh 'docker-compose down -v || true'
            }
        }
    }
}
