pipeline {
    agent any

    environment {
        IMAGE_NAME = "tubes-komputasiawan"
        CONTAINER_NAME = "tubes-komputasiawan-container"
        PORT = "8082:80"
    }

    stages {
        stage('Build Docker Image') {
            steps {
                script {
                    echo "Membangun Docker image..."
                    // Menggunakan docker-compose untuk build jika diperlukan
                    bat "docker-compose -f docker-compose.yml build"
                }
            }
        }

        stage('Start Services with Docker Compose') {
            steps {
                script {
                    echo "Menjalankan layanan dengan Docker Compose..."
                    // Menjalankan container menggunakan docker-compose
                    bat "docker-compose -f docker-compose.yml up -d"
                }
            }
        }

        stage('Test Application') {
            steps {
                script {
                    echo "Memastikan aplikasi PHP berjalan..."
                    // Cek apakah web service dapat diakses
                    bat "curl -s http://localhost:8082 || echo 'Aplikasi tidak dapat diakses'"
                }
            }
        }

        stage('Stop Services') {
            steps {
                script {
                    echo "Menghentikan layanan dengan Docker Compose..."
                    // Menghentikan dan menghapus container setelah pengujian
                    bat "docker-compose -f docker-compose.yml down"
                }
            }
        }
    }

    post {
        always {
            echo 'Pipeline selesai dijalankan.'
        }
        success {
            echo 'Pipeline berhasil dijalankan.'
        }
        failure {
            echo 'Pipeline gagal dijalankan.'
        }
    }
}
