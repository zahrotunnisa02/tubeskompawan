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

                    // Mendapatkan NodePort dari service Kubernetes
                    def NODE_PORT = bat(
                        script: """
                            set KUBECONFIG=${KUBECONFIG_PATH} 
                            kubectl get svc ${KUBE_SERVICE_NAME} -o=jsonpath="{.spec.ports[0].nodePort}"
                        """,
                        returnStdout: true
                    ).trim()

                    echo "NodePort yang didapat: ${NODE_PORT}"

                    // Uji koneksi ke aplikasi dengan curl
                    bat """
                        curl -s http://127.0.0.1:${NODE_PORT} || echo Aplikasi tidak dapat diakses
                    """
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
