pipeline {
    agent any // Gunakan agen apa saja untuk step pertama
    stages {
        stage("Inisiasi dari GitHub") {
            steps {
                echo "Ini Jenkins pipeline kelompok saya"
            }
        }
        stage("Dockerfile Agent Test") {
            agent { dockerfile true } // Gunakan Dockerfile agent khusus untuk stage ini
            steps {
                // Jalankan perintah dalam container Docker
                sh 'node --version'
                sh 'svn --version'
            }
        }
    }
}
