pipeline {
    agent any

    environment {
        IMAGE_NAME = "tubes-komputasiawan"
        CONTAINER_NAME = "tubes-komputasiawan-container"
        PORT = "8082:80"
        DISCORD_WEBHOOK = "https://discord.com/api/webhooks/1326360114302685245/Ifee6RXA7sX3hYb1zzMtzsCsu7SFGJNvevD9CKq9FbK6nERV2mgBuXp_uBBJrJEK_M-H"
    }

    stages {
        stage('Login to Docker Registry') {
            steps {
                script {
                    echo "Login ke Docker Hub..."
                    withCredentials([usernamePassword(credentialsId: 'docker-hub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                        bat "docker login -u ${DOCKER_USER} -p ${DOCKER_PASS}"
                    }
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    echo "Membangun Docker image..."
                    bat "docker build -t ${IMAGE_NAME}:latest ."
                    echo "Memeriksa apakah Docker Compose sedang berjalan..."
                    def isRunning = bat(script: "docker-compose ps -q", returnStdout: true).trim()
            
                    if (isRunning) {
                        echo "Docker Compose sedang berjalan, menghentikan layanan..."
                        bat "docker-compose down"
                    }
                    echo "Menjalankan Docker Compose..."
                    // Jalankan Docker Compose
                    bat "docker-compose up -d"
                }
            }
        }

        stage('Push Docker Image to Registry') {
            steps {
                script {
                    echo "Mendorong Docker image ke registry..."
                    withCredentials([usernamePassword(credentialsId: 'docker-hub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                        bat """
                            docker tag ${IMAGE_NAME}:latest ${DOCKER_USER}/${IMAGE_NAME}:latest
                            docker push ${DOCKER_USER}/${IMAGE_NAME}:latest
                        """
                    }
                }
            }
        }

        stage('Login Discord') {
            steps {
                script {
                    echo "Login ke Discord Webhook..."
                }
            }
        }

        stage('Notifikasi Discord') {
            steps {
                script {
                    def message = [
                        content: "Pipeline berhasil dijalankan! 🎉",
                        username: "Jenkins Bot"
                    ]
                    httpRequest(
                        httpMode: 'POST',
                        url: DISCORD_WEBHOOK,
                        requestBody: new groovy.json.JsonBuilder(message).toString(),
                        contentType: 'APPLICATION_JSON'
                    )
                }
            }
        }

        stage('Bersihkan Docker') {
            steps {
                script {
                    echo "Membersihkan container Docker yang tidak aktif..."
                    bat "docker system prune -f"
                }
            }
        }
    }

    post {
        always {
            echo 'Pipeline selesai dijalankan.'
        }
        success {
            script {
                def message = [
                    content: "Pipeline berhasil dieksekusi dengan sukses! ✅",
                    username: "Jenkins Bot"
                ]
                httpRequest(
                    httpMode: 'POST',
                    url: DISCORD_WEBHOOK,
                    requestBody: new groovy.json.JsonBuilder(message).toString(),
                    contentType: 'APPLICATION_JSON'
                )
            }
        }
        failure {
            script {
                def message = [
                    content: "Pipeline gagal dijalankan. ❌",
                    username: "Jenkins Bot"
                ]
                httpRequest(
                    httpMode: 'POST',
                    url: DISCORD_WEBHOOK,
                    requestBody: new groovy.json.JsonBuilder(message).toString(),
                    contentType: 'APPLICATION_JSON'
                )
            }
        }
    }
}
