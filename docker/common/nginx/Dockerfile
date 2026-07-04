# Stage 1: Build assets
FROM node:14.15.5 AS builder

ARG BUILD_ENV=production

# Set working directory
WORKDIR /var/www

# Copy Laravel application code
COPY . /var/www

# Install Node.js dependencies and build assets
RUN npm ci && \
    if [ "$BUILD_ENV" = "production" ]; then npm run production; else npm run development; fi

# Stage 2: Nginx production image
FROM nginx:alpine

# Copy custom Nginx configuration
# -----------------------------------------------------------
# Replace the default Nginx configuration with our custom one
# that is optimized for serving a Laravel application.
# -----------------------------------------------------------
COPY ./docker/common/nginx/nginx.conf /etc/nginx/nginx.conf

# Copy Laravel's public assets from the builder stage
# -----------------------------------------------------------
# We only need the 'public' directory from our Laravel app.
# -----------------------------------------------------------
COPY --from=builder /var/www/public /var/www/public

# Set the working directory to the public folder
WORKDIR /var/www/public

# Expose port 80 and start Nginx
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
