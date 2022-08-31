FROM node:10-alpine
RUN mkdir -p /home/node/app/node_modules && chown -R node:node /home/node/app
WORKDIR /home/node/app
COPY package*.json ./
#COPY resources ./
COPY webpack.mix.js ./
USER node
#RUN npm install npm@latest -g
#RUN npm install
RUN npm rebuild node-sass
COPY --chown=node:node . .
EXPOSE 8080
CMD [ "npm", "run", "hot" ]
