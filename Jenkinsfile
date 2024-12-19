pipeline {
    agent any

    environment {
        IMAGE_NAME = "tubes-komputasiawan" // Nama image Docker
        CONTAINER_NAME = "tubes-komputasiawan-container" // Nama container
        PORT = "8082:80" // Port mapping (host:container)
    }

    stages {
        stage('Ini Pipeline Kelompok Saya') {
            steps {
                echo 'Pipeline ini dibuat oleh kelompok saya untuk menjalankan Docker.'
            }
        }

        stage('Build Image Docker Tubes Komputasiawan') {
            steps {
                echo 'Building Docker image...'
                script {
                    // Build Docker image dari Dockerfile
                    bat "docker build -t ${IMAGE_NAME} ."
                }
            }
        }

        stage('Jalankan Container Docker') {
            steps {
                echo 'Running Docker container...'
                script {
                    // Jalankan container dari image yang sudah dibuild
                    bat "docker run -d --name ${CONTAINER_NAME} -p ${PORT} ${IMAGE_NAME}"
                }
            }
        }
    }

    post {
        always {
            echo 'Pipeline selesai dijalankan.'
        }
        failure {
            echo 'Pipeline gagal dijalankan.'
        }
    }
}
