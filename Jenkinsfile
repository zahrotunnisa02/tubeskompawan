pipeline {
    agent any

    environment {
        IMAGE_NAME = "tubes-komputasiawan"       // Nama image Docker
        CONTAINER_NAME = "tubes-komputasiawan-container" // Nama container
        PORT = "8082:80"                        // Port mapping (host:container)
        REGISTRY = "user/tubes-komputasiawan"   // Nama repository Docker Hub (ganti 'user' dengan username Anda)
    }

    stages {
        stage('Inisialisasi') {
            steps {
                echo 'Pipeline ini dibuat oleh kelompok saya untuk menjalankan Docker.'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    echo "Membangun Docker image: ${IMAGE_NAME}:latest"
                    docker.build("${IMAGE_NAME}:latest", ".")
                }
            }
        }

        stage('Run Container') {
            steps {
                script {
                    // Hentikan container jika sudah ada
                    sh """
                    docker ps -q --filter "name=${CONTAINER_NAME}" | grep -q . && docker stop ${CONTAINER_NAME} && docker rm ${CONTAINER_NAME} || true
                    """

                    // Jalankan container dengan nama spesifik
                    echo "Menjalankan container: ${CONTAINER_NAME}"
                    sh """
                    docker run -d --name ${CONTAINER_NAME} -p ${PORT} ${IMAGE_NAME}:latest
                    """
                }
            }
        }

        stage('Test Application') {
            steps {
                script {
                    echo "Melakukan pengujian aplikasi di container: ${CONTAINER_NAME}"
                    // Contoh perintah pengujian
                    sh """
                    docker exec ${CONTAINER_NAME} node --version
                    docker exec ${CONTAINER_NAME} php artisan --version || true
                    """
                }
            }
        }

        stage('Push to Docker Registry') {
            steps {
                script {
                    echo "Login ke Docker Registry dan push image."
                    sh """
                    echo $DOCKER_PASSWORD | docker login -u $DOCKER_USERNAME --password-stdin
                    docker tag ${IMAGE_NAME}:latest ${REGISTRY}:latest
                    docker push ${REGISTRY}:latest
                    """
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
