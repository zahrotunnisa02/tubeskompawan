pipeline {
    agent any

    environment {
        IMAGE_NAME = "tubes-komputasiawan"
        CONTAINER_NAME = "tubes-komputasiawan-container"
        PORT = "8082:80"
        KUBE_DEPLOYMENT_NAME = "tubes-komputasiawan-deployment"
        KUBE_SERVICE_NAME = "tubes-komputasiawan-service"
    }

    stages {
        stage('Login to Docker Registry') {
            steps {
                script {
                    echo "Login ke Docker Hub..."

                    // Memuat kredensial dari Jenkins Credentials Store
                    withCredentials([usernamePassword(credentialsId: 'docker-hub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                        bat "docker login -u ${DOCKER_USER} -p ${DOCKER_PASS}"
                    }
                    }
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    echo "Membangun Docker image..."
                    // Using withCredentials to inject kubeconfig or other authentication details
                    withCredentials([file(credentialsId: 'kubeconfig-file', variable: 'KUBECONFIG')]) {
                    bat "kubectl --kubeconfig=${KUBECONFIG} apply -f k8s-deployment.yml"
                }
            }
        }

        stage('Push Docker Image to Registry') {
            steps {
                script {
                    echo "Mendorong Docker image ke registry..."
                    withCredentials([usernamePassword(credentialsId: 'docker-hub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                        bat "docker tag ${IMAGE_NAME}:latest ${DOCKER_USER}/${IMAGE_NAME}:latest"
                        bat "docker push ${DOCKER_USER}/${IMAGE_NAME}:latest"
                    }
                }
            }
        }

        stage('Deploy Application to Kubernetes') {
            steps {
                script {
                    echo "Melakukan deployment ke Kubernetes..."
                    bat "kubectl apply -f k8s-deployment.yml"
                }
            }
        }

        stage('Test Kubernetes Application') {
            steps {
                script {
                    echo "Memastikan aplikasi berjalan di Kubernetes..."
                    def NODE_PORT = bat(script: "kubectl get svc ${KUBE_SERVICE_NAME} -o=jsonpath='{.spec.ports[0].nodePort}'", returnStdout: true).trim()
                    echo "Aplikasi tersedia di port: ${NODE_PORT}"
                    bat "curl -s http://127.0.0.1:${NODE_PORT} || echo 'Aplikasi tidak dapat diakses'"
                }
            }
        }

        stage('Clean Up Kubernetes Resources') {
            steps {
                script {
                    echo "Membersihkan resource Kubernetes..."
                    bat "kubectl delete deployment ${KUBE_DEPLOYMENT_NAME}"
                    bat "kubectl delete service ${KUBE_SERVICE_NAME}"
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
