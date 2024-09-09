import subprocess

class MonitorJournalctl:
    def __init__(self):
        self.process = None

    def start_monitoring(self):
        """Start monitoring the journal logs in real time."""
        try:
            # Start the journalctl process to follow logs (-f)
            self.process = subprocess.Popen(
                ['sudo', 'journalctl', '-f'],
                stdout=subprocess.PIPE,
                stderr=subprocess.PIPE,
                text=True
            )
            print("Monitoring journal logs...")
        except Exception as e:
            print(f"Failed to start journalctl: {e}")

    def get_next_record(self):
        """Get the next record from the journalctl log."""
        if self.process is None:
            raise RuntimeError("MonitorJournalctl has not been started. Call start_monitoring() first.")

        try:
            # Read the next line from the process output
            next_record = self.process.stdout.readline().strip()
            return next_record
        except Exception as e:
            print(f"Error while reading the log: {e}")
            return None

    def stop_monitoring(self):
        """Stop monitoring the journal logs."""
        if self.process:
            self.process.terminate()
            self.process.wait()
            print("Stopped monitoring journal logs.")

# Example usage
if __name__ == "__main__":
    monitor = MonitorJournalctl()
    monitor.start_monitoring()

    # Fetch and print 5 log records
    for _ in range(5):
        record = monitor.get_next_record()
        print(f"Log: {record}")

    monitor.stop_monitoring()

