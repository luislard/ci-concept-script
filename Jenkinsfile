pipeline {
    agent any
    stages {
        stage('Stage 1: Download Docker Repo') {
            steps {
                build job: 'ci-concept-docker'
                echo 'Docker repo was Downloaded'
            }
        }
        stage('Stage 2: Build') {
            steps {
                dir ('../ci-concept-docker') {
                  echo 'Starting Docker Containers'
                  sh './develop up -d'
                  echo 'Installing Dependencies'
                  sh './develop composer install'
                  echo 'Running PHPUnit Tests'
                  sh './develop t ./tests'
                  echo 'Destroying Containers'
                  sh './develop down'
                }
            }
        }
        stage('Stage 3: Deploy to Staging') {
            environment {
                DOCKERCOMPOSEPATH='/home/ubuntu/ci-concept-docker'
                APP_PORT=80
            }
            steps {
                dir ('../ci-concept-docker') {
                  echo 'Copying docker repo to Staging'
                  sh "scp -P 4263 -r . ubuntu@172.31.44.218:${env.DOCKERCOMPOSEPATH}"
                }
                dir ('../ci-concept-script') {
                  echo 'Copying project repo to Staging'
                  sh 'scp -P 4263 -r . ubuntu@172.31.44.218:/home/ubuntu/ci-concept-script'
                }
                echo 'Starting Docker Containers on Staging'
                sh 'printenv'
                sh 'ssh -p 4263 ubuntu@172.31.44.218 APP_PORT=80'
                sh "ssh -p 4263 ubuntu@172.31.44.218 docker-compose -f ${env.DOCKERCOMPOSEPATH}/docker-compose.dev.yml up -d"
                echo 'Installing Dependencies on Staging'
                sh "ssh -p 4263 ubuntu@172.31.44.218 docker-compose -f ${env.DOCKERCOMPOSEPATH}/docker-compose.dev.yml composer install"
            }
        }
    }
}
