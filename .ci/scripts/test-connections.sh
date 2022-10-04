
#!/bin/bash
# 
# Test connections to docker containers

connect()
{
	echo "Testing connection to ${1}"

	curl -s -o /dev/null ${1}
	if [ $? -ne 0 ]
		then
			echo "Failed. Aborting job";
			exit 1
	fi

	echo "OK"
}

# Waiting
sleep 5

# Test
connect ${NTFY_URI}
connect ${HTTPBIN_URI}
