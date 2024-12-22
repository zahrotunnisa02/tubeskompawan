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
                        sh "docker login -u ${DOCKER_USER} -p ${DOCKER_PASS}"
                    }
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    echo "Membangun Docker image..."
                    sh "docker build -t ${IMAGE_NAME}:latest ."
                }
            }
        }

        stage('Push Docker Image to Registry') {
            steps {
                script {
                    echo "Mendorong Docker image ke registry..."
                    withCredentials([usernamePassword(credentialsId: 'docker-hub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                        sh "docker tag ${IMAGE_NAME}:latest ${DOCKER_USER}/${IMAGE_NAME}:latest"
                        sh "docker push ${DOCKER_USER}/${IMAGE_NAME}:latest"
                    }
                }
            }
        }

        stage('Deploy Application to Kubernetes') {
            steps {
                script {
                    echo "Melakukan deployment ke Kubernetes..."
                    writeFile file: 'k8s-deployment.yml', text: """
                    apiVersion: apps/v1
                    kind: Deployment
                    metadata:
                      name: ${KUBE_DEPLOYMENT_NAME}
                    spec:
                      replicas: 2
                      selector:
                        matchLabels:
                          app: ${KUBE_DEPLOYMENT_NAME}
                      template:
                        metadata:
                          labels:
                            app: ${KUBE_DEPLOYMENT_NAME}
                        spec:
                          containers:
                          - name: ${IMAGE_NAME}
                            image: ${DOCKER_USER}/${IMAGE_NAME}:latest
                            ports:
                            - containerPort: 80
                    ---
                    apiVersion: v1
                    kind: Service
                    metadata:
                      name: ${KUBE_SERVICE_NAME}
                    spec:
                      selector:
                        app: ${KUBE_DEPLOYMENT_NAME}
                      ports:
                      - protocol: TCP
                        port: 8082
                        targetPort: 80
                      type: NodePort
                    """
                    sh "kubectl apply -f k8s-deployment.yml"
                }
            }
        }

        stage('Test Kubernetes Application') {
            steps {
                script {
                    echo "Memastikan aplikasi berjalan di Kubernetes..."
                    def NODE_PORT = sh(script: "kubectl get svc ${KUBE_SERVICE_NAME} -o=jsonpath='{.spec.ports[0].nodePort}'", returnStdout: true).trim()
                    echo "Aplikasi tersedia di port: ${NODE_PORT}"
                    sh "curl -s http://127.0.0.1:${NODE_PORT} || echo 'Aplikasi tidak dapat diakses'"
                }
            }
        }

        stage('Clean Up Kubernetes Resources') {
            steps {
                script {
                    echo "Membersihkan resource Kubernetes..."
                    sh "kubectl delete deployment ${KUBE_DEPLOYMENT_NAME}"
                    sh "kubectl delete service ${KUBE_SERVICE_NAME}"
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
