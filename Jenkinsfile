pipeline {
    agent any

    environment {
        IMAGE_NAME = "tubes-komputasiawan"       // Nama image Docker
        CONTAINER_NAME = "tubes-komputasiawan-container"    // Nama container
        PORT = "8082:80"                         // Port mapping (host:container)
    }

    stages {
        stage('Build Docker Image') {
            steps {
                script {
                    echo "Membangun Docker image: ${IMAGE_NAME}:latest"
                    bat "docker build -t ${IMAGE_NAME}:latest ."
                }
            }
        }

        stage('Run Docker Container') {
            steps {
                script {
                    // Hentikan container jika sudah ada sebelumnya
                    echo "Memastikan tidak ada container dengan nama yang sama berjalan..."
                    bat """
                    docker ps -q --filter "name=${CONTAINER_NAME}" && docker stop ${CONTAINER_NAME} && docker rm ${CONTAINER_NAME} || echo Container tidak ditemukan
                    """

                    // Jalankan container menggunakan image yang telah dibuat
                    echo "Menjalankan container ${CONTAINER_NAME}..."
                    bat """
                    docker run -d --name ${CONTAINER_NAME} -p ${PORT} ${IMAGE_NAME}:latest
                    """
                }
            }
        }

        stage('Start Services with Docker Compose') {
            steps {
                script {
                    echo "Menjalankan layanan dengan Docker Compose..."
                    // Pastikan file docker-compose.yml ada di lokasi yang benar
                    bat "docker-compose -f docker-compose.yml up -d"
                }
            }
        }
    }

    post {
        always {
            echo "Pipeline selesai dijalankan."
        }
        success {
            echo "Pipeline berhasil dijalankan."
        }
        failure {
            echo "Pipeline gagal dijalankan."
        }
    }
}
