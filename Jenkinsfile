pipeline {
    agent any

    environment {
        IMAGE_NAME = "tubes-komputasiawan"       // Nama image Docker
        CONTAINER_NAME = "tubes-komputasiawan-container" // Nama container
        PORT = "8082:80"                        // Port mapping (host:container)
    }

    stages {
        stage('Build Docker Image') {
            steps {
                script {
                    echo "Membangun Docker image: ${IMAGE_NAME}:latest"
                    docker.build("${IMAGE_NAME}:latest", ".") // Build image menggunakan Dockerfile di root
                }
            }
        }

        stage('Run Docker Container') {
            steps {
                script {
                    // Hentikan container jika sudah ada sebelumnya
                    echo "Memastikan tidak ada container dengan nama yang sama berjalan..."
                    sh """
                    docker ps -q --filter "name=${CONTAINER_NAME}" | grep -q . && docker stop ${CONTAINER_NAME} && docker rm ${CONTAINER_NAME} || true
                    """

                    // Jalankan container menggunakan image yang telah dibuat
                    echo "Menjalankan container ${CONTAINER_NAME}..."
                    sh """
                    docker run -d --name ${CONTAINER_NAME} -p ${PORT} ${IMAGE_NAME}:latest
                    """
                }
            }
        }

        stage('Test Application') {
            steps {
                script {
                    // Jalankan perintah testing di dalam container
                    echo "Melakukan pengujian aplikasi di dalam container ${CONTAINER_NAME}..."
                    sh """
                    docker exec ${CONTAINER_NAME} node --version || echo "Node.js tidak ditemukan"
                    docker exec ${CONTAINER_NAME} php artisan --version || echo "Laravel tidak ditemukan"
                    """
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
