pipeline {
    agent any
    stages {
        stage('Inisiasi dari GitHub') {
            steps {
                echo "Ini Jenkins pipeline kelompok saya"
            }
        }
        stage('Dockerfile Agent Test') {
            steps {
                script {
                    // Konversi workspace path ke Linux-style
                    def workspacePath = pwd().replaceAll('C:', '/c').replaceAll('\\\\', '/')
                    echo "Workspace Path: ${workspacePath}"

                    // Jalankan container menggunakan image 'tubes-komputasiawan'
                    docker.image('tubes-komputasiawan').inside("-v ${workspacePath}:/workspace") {
                        sh 'node --version'
                        sh 'svn --version'
                    }
                }
            }
        }
    }
}
