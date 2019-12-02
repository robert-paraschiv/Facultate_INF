#include <iostream> 

using namespace std;

int cmmdc(int a, int b)
{
	if (b == 0)
		return a;
	return cmmdc(b, a % b);

}

int cmmmc(int a, int b)
{
	return (a * b) / cmmdc(a, b);
}

// Driver program to test above function 
int main()
{
	int m, n;
	cin >> m >> n;
	cout << "CMMDC al " << m << " si " << n << " este: " << cmmdc(m, n);
	cout << endl;
	cout << "CMMMC al " << m << " si " << n << " este: " << cmmmc(m, n);
	return 0;
}
