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

        stage('Build Docker Image') {
            steps {
                script {
                    // Build Docker image menggunakan Dockerfile
                    docker.build('tubes-komputasiawan:latest', '.')
                }
            }
        }

        stage('Run Container') {
            steps {
                script {
                    // Jalankan container menggunakan image yang baru dibangun
                    docker.image('tubes-komputasiawan:latest').inside {
                        sh 'node --version' // Contoh perintah di dalam container
                        sh 'php artisan --version' // Contoh perintah Laravel (jika ada)
                    }
                }
            }
        }

        stage('Test Application') {
            steps {
                script {
                    // Jalankan pengujian unit atau integrasi
                    sh 'npm test' // Contoh: menjalankan tes aplikasi berbasis Node.js
                }
            }
        }

        stage('Push to Docker Registry') {
            steps {
                script {
                    // Login ke Docker Registry
                    sh 'docker login -u $DOCKER_USERNAME -p $DOCKER_PASSWORD'

                    // Push image ke Docker Hub atau registry lain
                    sh 'docker tag tubes-komputasiawan:latest user/tubes-komputasiawan:latest'
                    sh 'docker push user/tubes-komputasiawan:latest'
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
