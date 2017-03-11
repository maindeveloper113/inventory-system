//
//  InventoryDetailViewController.swift
//  inventory
//
//  Created by admin on 1/27/17.
//  Copyright © 2017 admin. All rights reserved.
//

import UIKit

class InventoryDetailViewController: UIViewController, UIPickerViewDelegate, UIPickerViewDataSource {

    @IBOutlet var photo: UIImageView!
    @IBOutlet var lblPartNumber: UILabel!
    @IBOutlet var lblSerialNumber: UILabel!
    @IBOutlet var lblLocation: UILabel!
    @IBOutlet var lblQuantity: UILabel!
    @IBOutlet var lblDescription: UILabel!
    @IBOutlet var lblRegisterName: UILabel!
    @IBOutlet var lblRegisterTime: UILabel!
    @IBOutlet var lblRemark: UILabel!
    
    @IBOutlet var lblRemoveQuantity: UILabel!
    @IBOutlet var btnRemoveQuantity: UIButton!
        
    @IBOutlet var pickRemoveQuantity: UIPickerView!
    @IBOutlet var pickerPanel: UIView!
    
    @IBOutlet var activityindicatorcontainer: UIView!
    var partNumber: String?
    var serialNumber: String?
    var location: String?
    var quantity: String?
    var descript: String?
    var registerName: String?
    var registerTime: String?
    var remark: String?
    var inventoryId: String?
    var inventoryImageURL: String?
    var inventoryViewController: InventoryViewController?

    var quantityInt: Int?
    var user_id: String!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        setInit()
        // Do any additional setup after loading the view.
      
    }
    

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func setInit() {
        pickerPanel.isHidden = true
        photo.sd_setImage(with: NSURL.init(string: inventoryImageURL!) as! URL, placeholderImage: UIImage.init(named: "placeholder.png"))
        lblPartNumber.text = partNumber
        lblSerialNumber.text = serialNumber
        lblLocation.text = location
        lblQuantity.text = quantity
        lblDescription.text = descript
        lblRegisterName.text = registerName
        lblRegisterTime.text = registerTime
        lblRemark.text = remark
        
        
        quantityInt = Int(quantity!)!
        if  quantityInt! > 1 {
            btnRemoveQuantity.isHidden = false
        }
        else {
            btnRemoveQuantity.isHidden = true
        }
        
        let session = SessionManager()
        user_id = session.getUserDetails()[session.KEY_UserId]
    }
    

    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        return 1
    }
    
    
    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        return self.quantityInt!
        
    }
    
   
    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String? {
        return String(row + 1)
    }
    
   
    func pickerView(_ pickerView: UIPickerView, didSelectRow row: Int, inComponent component: Int) {
        lblRemoveQuantity.text = String(row + 1)
    }
    
    func requestRemove() {
        let json = ["inventory_id":self.inventoryId, "user_id":self.user_id, "quantity":self.lblRemoveQuantity.text]
        
        activityindicatorcontainer.isHidden = false
        showActivityIndicatory(uiView: activityindicatorcontainer)
        
        do {
            let jsonData = try JSONSerialization.data(withJSONObject: json, options: .prettyPrinted)
            
            let url = StaticData.getlink() + "remove_inventory.php"
            
            var request = URLRequest(url: URL(string: url)!)
            
            request.httpMethod = "POST"
            request.httpBody = jsonData
            request.setValue("application/json; charset=utf-8", forHTTPHeaderField: "Content-Type")
            
            
            let task = URLSession.shared.dataTask(with: request) { (data: Data?, response: URLResponse?, error: Error?) in
                
                if error != nil
                {
                    print("error=\(error)")
                    return
                }
                
                // You can print out response object
                print("response = \(response)")
                
                //Let's convert response sent from a server side script to a NSDictionary object:
                do {
                    
                    let json = try JSONSerialization.jsonObject(with: data!, options: .mutableContainers) as? NSDictionary
                    
                    if let parseJSON = json {
                        
                        // Now we can access value of First Name by its key
                        let remove_error = parseJSON["error"] as? Bool
                        
                        self.removeResponse(error: remove_error!)
                        
                        
                        
                        
                    }
                    
                } catch {
                    print("session error")
                }
                self.activityindicatorcontainer.isHidden = true
            }
            task.resume()
            
            
        } catch {
            print("json error")
        }
    }
    
    func removeResponse(error: Bool) {
        DispatchQueue.main.async {[unowned self] in
            
            if error {
                let alert = UIAlertController(title: "Warning", message: "Inventory remove failed. Try again.", preferredStyle: UIAlertControllerStyle.alert)
                alert.addAction(UIAlertAction(title: "Yes", style: UIAlertActionStyle.default, handler:nil))
                self.present(alert, animated: true, completion: nil)

            }
            else {
                self.inventoryViewController?.refresh()
                self.navigationController?.popViewController(animated: true)
                
                
                
            }
            
            
        }
    }
    
    func showActivityIndicatory(uiView: UIView) {
        
        let loadingView: UIView = UIView()
        loadingView.frame = CGRect.init(x: 0, y: 0, width: 80, height: 80)
        let screenSize = UIScreen.main.bounds
        let screenWidth = screenSize.width
        let screenHeight = screenSize.height
        loadingView.center = CGPoint.init(x: screenWidth / 2, y: screenHeight / 2)
        loadingView.backgroundColor = UIColor.lightGray.withAlphaComponent(0.7)
        loadingView.clipsToBounds = true
        loadingView.layer.cornerRadius = 10
        
        let actInd: UIActivityIndicatorView = UIActivityIndicatorView()
        actInd.frame = CGRect.init(x:0.0, y:0.0, width:40.0, height:40.0);
        actInd.activityIndicatorViewStyle =
            UIActivityIndicatorViewStyle.whiteLarge
        
        actInd.center = CGPoint.init(x: loadingView.frame.size.width / 2,
                                     y:loadingView.frame.size.height / 2);
        loadingView.addSubview(actInd)
        uiView.addSubview(loadingView)
        
        actInd.startAnimating()
    }
    

    
    @IBAction func btnRemoveQuantityConfirm(_ sender: Any) {
        pickerPanel.isHidden = true
    }
   
    @IBAction func goBack(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    @IBAction func pickerRemoveQuantity(_ sender: Any) {
        pickerPanel.isHidden = false
    }

    @IBAction func removeInventory(_ sender: Any) {
        
        
        
        let alert = UIAlertController(title: "Alert", message: "Are you sure want remove this inventory?", preferredStyle: UIAlertControllerStyle.alert)
        let actionYes = UIAlertAction(title: "Yes", style: UIAlertActionStyle.default, handler:{(ACTION) in
            self.requestRemove()
        })
        let actionCancel = UIAlertAction(title: "No", style: UIAlertActionStyle.default, handler:nil)
        alert.addAction(actionYes)
        alert.addAction(actionCancel)
        self.present(alert, animated: true, completion: nil)
    }
    
    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
