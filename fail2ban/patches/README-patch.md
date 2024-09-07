# README-patch.md

This patch solves a problem I was having with fail2ban. It used to insert chains in INPUT at the front
but this caused a problem, as I used the first entry to make sure my development box was never
banned.

As you can see from this example, after the patch, the code now places the created chains after
rule #1, which is reserved for me.

```
Chain INPUT (policy ACCEPT 91509 packets, 11M bytes)
 pkts bytes target     prot opt in     out     source               destination
 4442  323K ACCEPT     all  --  *      *       <my-ip-address>      0.0.0.0/0
    0     0 DROP       tcp  --  *      *       0.0.0.0/0            0.0.0.0/0            tcp dpt:21
    0     0 DROP       tcp  --  *      *       0.0.0.0/0            0.0.0.0/0            tcp dpt:20
   22  2433 f2b-a      tcp  --  *      *       0.0.0.0/0            0.0.0.0/0            multiport dports 80,443
   22  2433 f2b-b      tcp  --  *      *       0.0.0.0/0            0.0.0.0/0            multiport dports 80,443
    0     0 f2b-sshd   tcp  --  *      *       0.0.0.0/0            0.0.0.0/0            multiport dports 22
```

### How to install

  It's easy, just do

```
    sudo ./install.sh
```

  Don't worry, the install scrip makes .orig copies of the etc file before it changes them
  so you can always revert.

### Notes

 1. The patches are marked with the string '#Patch' in the code.
 2. As usual, chatGPT4 did the heavy lifting. See README-patches-chatGPT-help.md for my dialog with it for this patch.
 3. I also killed off ftp, using ports 20 and 21. 