# Use official Node.js image
FROM node:18

# Set the working directory in the container
WORKDIR /usr/src/app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install project dependencies
RUN npm install --legacy-peer-deps --no-audit --progress=false

# Copy application code
COPY . .

# Expose the application on port 3000
EXPOSE 3000

# Start the application
CMD ["npm", "start"]
