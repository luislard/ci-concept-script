pipeline {
    agent any
    stages {
        stage('Stage 1: Download Docker Repo') {
            steps {
                build job: 'download-docker-repo'
                echo 'Docker repo was Downloaded'
            }
        }
        stage('Stage 2: Starting docker containers') {
            steps {
                sh 'cd ../download-docker-repo'
                sh './develop up -d'
            }
        }
    }
}
