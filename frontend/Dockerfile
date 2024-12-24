# Use official Node.js image
FROM node:18

# Set the working directory in the container
WORKDIR /usr/src/app

# Install yarn (Yarn is usually not pre-installed with Node images)
RUN npm install -g yarn

# Copy package.json and yarn.lock files
COPY package*.json ./

# Install project dependencies with yarn (instead of npm)
RUN yarn install --force

# Copy application code
COPY . .

# Expose the application on port 3000
EXPOSE 3000

# Start the application using yarn
CMD ["yarn", "start"]
