FROM gitpod/workspace-full

# Avoid prompts from apt
ENV DEBIAN_FRONTEND=noninteractive

# Install sudo and other essential tools
RUN apt-get update && apt-get install -y \
    sudo \
    curl \
    wget \
    git \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

CMD ["/bin/bash"]
