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
        stage('Login to Docker Registry dan start minikube') {
            steps {
                script {
                    echo "Login ke Docker Hub..."
                    withCredentials([usernamePassword(credentialsId: 'docker-hub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                        bat "docker login -u ${DOCKER_USER} -p ${DOCKER_PASS}"

                    echo "Memulai Minikube..."
                    bat """
                        minikube stop
                        minikube delete
                        minikube start --driver=docker
                    """
                    }
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    echo "Membangun Docker image..."
                    bat "docker build -t ${IMAGE_NAME}:latest ."
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
                        kubectl apply -f k8s-deployment.yml
                    """
                }
            }
        }

        stage('Test Kubernetes Application') {
            steps {
                script {
                    echo "Memastikan aplikasi berjalan di Kubernetes..."
        
                    // Set KUBECONFIG dan dapatkan NodePort dari service
                    def NODE_PORT = bat(
                        script: """
                            @echo off
                            set KUBECONFIG=C:\\Users\\admin\\.kube\\config
                            kubectl get svc tubes-komputasiawan-service -o=jsonpath="{.spec.ports[0].nodePort}"
                        """,
                        returnStdout: true
                    ).trim()
        
                    if (!NODE_PORT?.isInteger()) {
                        error "Gagal mendapatkan NodePort. Pastikan service berjalan."
                    }
        
                    echo "NodePort ditemukan: ${NODE_PORT}"
        
                     // Mendapatkan IP Minikube
                    echo "Mendapatkan IP Minikube..."
                    def minikubeIp = bat(script: 'minikube ip', returnStdout: true).trim()
                    echo "Minikube IP: ${minikubeIp}"
                    
                    // Uji koneksi ke aplikasi dengan curl
                    echo "Mengakses aplikasi di http://${minikubeIp}:${nodePort}"
                    def response = bat(script: "curl -s http://${minikubeIp}:${nodePort}", returnStatus: true)
                    
                    if (response != 0) {
                        error "Aplikasi tidak dapat diakses di http://${minikubeIp}:${nodePort}"
                    } else {
                        echo "Aplikasi berhasil diakses di http://${minikubeIp}:${nodePort}"
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
                        kubectl delete deployment ${KUBE_DEPLOYMENT_NAME}
                        kubectl delete service ${KUBE_SERVICE_NAME}
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
