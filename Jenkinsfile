pipeline {
    agent any

    environment {
        IMAGE_NAME = "tubes-komputasiawan"
        CONTAINER_NAME = "tubes-komputasiawan-container"
        PORT = "8082:80"
        KUBE_DEPLOYMENT_NAME = "tubes-komputasiawan-deployment"
        KUBE_SERVICE_NAME = "tubes-komputasiawan-service"
        KUBECONFIG_PATH = "C:\\Users\\admin\\.kube\\config" // Ganti sesuai path kubeconfig Anda
    }

    stages {
        stage('Login to Docker Registry dan Start Minikube') {
            steps {
                script {
                    echo "Login ke Docker Hub..."
                    withCredentials([usernamePassword(credentialsId: 'docker-hub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                        bat "docker login -u ${DOCKER_USER} -p ${DOCKER_PASS}"
                    }
                    
                    echo "Memulai Minikube..."
                    bat """
                        minikube stop || echo "Minikube belum berjalan"
                        minikube delete || echo "Minikube sudah dihapus"
                        minikube start --driver=docker
                        minikube update-context

                        minikube status

                    """
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

        stage('Deploy Application to Kubernetes') {
            steps {
                script {
                    echo "Melakukan deployment ke Kubernetes..."
                    bat """
                        set KUBECONFIG=${KUBECONFIG_PATH}
                        kubectl config use-context minikube
                        kubectl cluster-info
                        kubectl apply -f k8s-deployment.yml --validate=false
                    """
                }
            }
        }

        stage('Test Kubernetes Application') {
            steps {
                script {
                    echo "Memastikan aplikasi berjalan di Kubernetes..."
                    
                    // Mendapatkan NodePort dari service
                    def NODE_PORT = bat(
                        script: """
                            @echo off
                            set KUBECONFIG=${KUBECONFIG_PATH}
                            kubectl get svc ${KUBE_SERVICE_NAME} -o=jsonpath="{.spec.ports[0].nodePort}"
                        """,
                        returnStdout: true
                    ).trim()

                    if (!NODE_PORT?.isInteger()) {
                        error "Gagal mendapatkan NodePort. Pastikan service berjalan."
                    }
                    
                    echo "NodePort ditemukan: ${NODE_PORT}"
                    
                    // Mendapatkan IP Minikube
                    echo "Mendapatkan IP Minikube..."
                    def MINIKUBE_IP = bat(script: "minikube ip", returnStdout: true).trim()
                    echo "Minikube IP: ${MINIKUBE_IP}"
                    
                    // Uji koneksi ke aplikasi dengan curl
                    echo "Mengakses aplikasi di http://${MINIKUBE_IP}:${NODE_PORT}"
                    def RESPONSE = bat(script: "curl -s http://${MINIKUBE_IP}:${NODE_PORT}", returnStatus: true)
                    
                    if (RESPONSE != 0) {
                        error "Aplikasi tidak dapat diakses di http://${MINIKUBE_IP}:${NODE_PORT}"
                    } else {
                        echo "Aplikasi berhasil diakses di http://${MINIKUBE_IP}:${NODE_PORT}"
                    }
                }
            }
        }

        stage('Clean Up Kubernetes Resources') {
            steps {
                script {
                    echo "Membersihkan resource Kubernetes..."
                    bat """
                        set KUBECONFIG=${KUBECONFIG_PATH}
                        kubectl delete deployment ${KUBE_DEPLOYMENT_NAME} || echo "Deployment sudah dihapus"
                        kubectl delete service ${KUBE_SERVICE_NAME} || echo "Service sudah dihapus"
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
