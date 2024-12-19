pipeline {
    agent any

    environment {
        COMPOSE_FILE = "docker-compose.yml" // File docker-compose Anda
        WEB_CONTAINER = "tubeskomputasiawan-web-1" // Nama container aplikasi PHP
        DB_CONTAINER = "tubeskomputasiawan-db-1"  // Nama container MySQL
        DB_USER = "root" // User database
        DB_PASSWORD = "123456" // Password database
        DB_NAME = "komputasi_awan" // Nama database
        SQL_FILE = "tubesweb.sql" // Path ke file SQL yang ingin diimpor
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

        stage('Ensure DB Container is Running') {
            steps {
                echo 'Ensuring the database container is running...'
                script {
                    // Cek apakah container DB berjalan
                    def status = bat(script: "docker ps -q -f name=${DB_CONTAINER}", returnStdout: true).trim()
                    if (status == "") {
                        echo "Starting the database container..."
                        bat "docker-compose up -d ${DB_CONTAINER}"
                    }
                }
            }
        }

        stage('Wait for DB to be Ready') {
            steps {
                echo 'Waiting for database to be ready...'
                script {
                    // Tunggu sampai MySQL siap menerima koneksi
                    waitForMySQLToBeReady(DB_CONTAINER, DB_USER, DB_PASSWORD)
                }
            }
        }

        stage('Database Import') {
            steps {
                echo 'Importing database...'
                script {
                    // Salin file SQL ke dalam container MySQL
                    bat "docker cp ${WORKSPACE}\\${SQL_FILE} ${DB_CONTAINER}:/tmp/${SQL_FILE}"
                    
                    // Verifikasi file telah disalin
                    bat "docker exec ${DB_CONTAINER} ls /tmp"

                    // Mengimpor file SQL ke dalam database MySQL
                    bat """
                    docker exec ${DB_CONTAINER} mysql -u${DB_USER} -p${DB_PASSWORD} ${DB_NAME} < /tmp/${SQL_FILE} || exit 1
                    """
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
                    docker exec ${DB_CONTAINER} mysql -u${DB_USER} -p${DB_PASSWORD} -e "USE ${DB_NAME}; SHOW TABLES;" || exit 1
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

// Fungsi untuk menunggu sampai MySQL siap menerima koneksi
def waitForMySQLToBeReady(container, dbUser, dbPassword) {
    def retries = 10
    def success = false
    for (int i = 0; i < retries; i++) {
        echo "Checking if MySQL is ready (${i + 1}/${retries})..."
        try {
            bat(script: "docker exec ${container} mysqladmin -u${dbUser} -p${dbPassword} ping --silent", returnStatus: true)
            success = true
            break
        } catch (Exception e) {
            echo "MySQL is not ready yet. Retrying in 10 seconds..."
            sleep(10)
        }
    }
    
    if (!success) {
        error "MySQL did not become ready after ${retries} attempts."
    }
}
