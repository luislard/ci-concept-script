pipeline {
    agent any
    environment {
        AWS_ACCESS_KEY_ID     = credentials('jenkins-aws-secret-key-id')
        DOCKER_REPO_NAME = 'ci-concept-docker'
    }
    stages {
        stage('Stage 1: Download Docker Repo') {
            steps {
                echo '==============================================='
                echo "Starting $STAGE_NAME"
                echo '==============================================='

                build job: "$DOCKER_REPO_NAME"
                echo 'Docker repo was Downloaded'

                echo '==============================================='
                echo "Finished $STAGE_NAME"
                echo '==============================================='
            }
        }
        stage('Stage 2: Build') {
            steps {
                echo '==============================================='
                echo "Starting $STAGE_NAME"
                echo '==============================================='

                dir ("../$DOCKER_REPO_NAME) {
                  echo 'Starting Docker Containers'
                  sh './develop up -d'
                  echo 'Installing Dependencies'
                  sh './develop composer install'
                  echo 'Running PHPUnit Tests'
                  sh './develop t ./tests'
                  echo 'Destroying Containers'
                  sh './develop down'
                }

                echo '==============================================='
                echo "Finished $STAGE_NAME"
                echo '==============================================='
            }
        }
        stage('Stage 3: Deploy to Staging') {
            environment {
                /****************************/
                /* Staging Server Variables */
                /****************************/
                DOCKERFOLDER="/home/ubuntu/$DOCKER_REPO_NAME"
                SSH_PORT=4263
                SSH_USER='ubuntu'
                SSH_IP='172.31.44.218'
                APP_PORT=80
            }
            steps {
                echo '==============================================='
                echo "Starting $STAGE_NAME"
                echo '==============================================='

                echo '==================='
                echo 'Available variables'
                echo '==================='

                sh 'printenv'

                echo '======================='
                echo 'Move folders to Staging'
                echo '======================='

                dir ("../$DOCKER_REPO_NAME") {
                  echo 'Copying docker repo to Staging'
                  sh "scp -P ${SSH_PORT} -r . ${SSH_USER}@${SSH_IP}:${env.DOCKERFOLDER}"
                }

                dir ("../$JOB_NAME") {
                  echo 'Copying project repo to Staging'
                  sh "scp -P ${SSH_PORT} -r . ${SSH_USER}@${SSH_IP}:/home/ubuntu/$JOB_NAME"
                }

                echo '====================================='
                echo 'Starting Docker Containers on Staging'
                echo '====================================='

                /* sh "ssh -p ${SSH_PORT} -o SendEnv=APP_PORT ${SSH_USER}@${SSH_IP} export APP_PORT=${env.APP_PORT}" */
                sh "ssh -p ${SSH_PORT} -o SendEnv=APP_PORT ${SSH_USER}@${SSH_IP} docker-compose -f ${env.DOCKERFOLDER}/docker-compose.dev.yml up -d"

                echo '=================================='
                echo 'Installing Dependencies on Staging'
                echo '=================================='

                sh "ssh -p ${SSH_PORT} -o SendEnv=APP_PORT ${SSH_USER}@${SSH_IP} docker-compose -f ${env.DOCKERFOLDER}/docker-compose.dev.yml exec -T php composer install"

                echo '==============================================='
                echo "Finished $STAGE_NAME"
                echo '==============================================='
            }
        }
    }
}
